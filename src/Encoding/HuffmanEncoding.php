<?php

declare(strict_types=1);


namespace Nejcc\PhpDatatypes\Encoding;

use Nejcc\PhpDatatypes\Interfaces\DecoderInterface;
use Nejcc\PhpDatatypes\Interfaces\EncoderInterface;
use InvalidArgumentException;

/**
 * Class HuffmanEncoding
 * Implements Huffman compression and decompression.
 */
class HuffmanEncoding implements EncoderInterface, DecoderInterface
{
    /**
     * Encodes the data using Huffman encoding.
     *
     * @param string $data
     * @return string The encoded data with serialized frequency table.
     */
    public function encode(string $data): string
    {
        if ($data === '') {
            throw new InvalidArgumentException('Cannot encode empty string.');
        }

        // Step 1: Build frequency table
        $frequency = $this->buildFrequencyTable($data);

        // Step 2: Build Huffman Tree
        $huffmanTree = $this->buildHuffmanTree($frequency);

        // Step 3: Generate Huffman Codes
        $codes = [];
        $this->generateCodes($huffmanTree, '', $codes);

        // Step 4: Encode data
        $encodedData = '';
        for ($i = 0, $len = strlen($data); $i < $len; $i++) {
            $char = $data[$i];
            $encodedData .= $codes[$char];
        }

        // Step 5: Serialize frequency table and encoded data
        // Prefix the encoded data with the JSON-encoded frequency table and a separator
        $serializedFrequency = json_encode($frequency);
        if ($serializedFrequency === false) {
            throw new InvalidArgumentException('Failed to serialize frequency table.');
        }

        // Use a unique separator (null byte) to split frequency table and encoded data
        $separator = "\0";

        // Convert bit string to byte string
        $byteString = $this->bitsToBytes($encodedData);

        return $serializedFrequency . $separator . $byteString;
    }

    /**
     * Decodes the data using Huffman decoding.
     *
     * @param string $data The encoded data with serialized frequency table.
     * @return string The original decoded data.
     */
    public function decode(string $data): string
    {
        if ($data === '') {
            throw new InvalidArgumentException('Cannot decode empty string.');
        }

        // Step 1: Split the frequency table and the encoded data
        $separatorPos = strpos($data, "\0");
        if ($separatorPos === false) {
            throw new InvalidArgumentException('Invalid encoded data format.');
        }

        $serializedFrequency = substr($data, 0, $separatorPos);
        $encodedDataBytes = substr($data, $separatorPos + 1);

        // Step 2: Deserialize frequency table
        $frequency = json_decode($serializedFrequency, true);
        if (!is_array($frequency)) {
            throw new InvalidArgumentException('Failed to deserialize frequency table.');
        }

        // Step 3: Rebuild Huffman Tree
        $huffmanTree = $this->buildHuffmanTree($frequency);

        // Step 4: Convert bytes back to bit string
        $encodedDataBits = $this->bytesToBits($encodedDataBytes);

        // Step 5: Decode bit string using Huffman Tree
        $decodedData = '';
        $currentNode = $huffmanTree;
        $totalBits = strlen($encodedDataBits);
        for ($i = 0; $i < $totalBits; $i++) {
            $bit = $encodedDataBits[$i];
            if ($bit === '0') {
                $currentNode = $currentNode->left;
            } else {
                $currentNode = $currentNode->right;
            }

            if ($currentNode->isLeaf()) {
                $decodedData .= $currentNode->character;
                $currentNode = $huffmanTree;
            }
        }

        return $decodedData;
    }

    /**
     * Builds a frequency table for the given data.
     *
     * @param string $data
     * @return array Associative array with characters as keys and frequencies as values.
     */
    private function buildFrequencyTable(string $data): array
    {
        $frequency = [];
        for ($i = 0, $len = strlen($data); $i < $len; $i++) {
            $char = $data[$i];
            if (isset($frequency[$char])) {
                $frequency[$char]++;
            } else {
                $frequency[$char] = 1;
            }
        }
        return $frequency;
    }

    /**
     * Builds the Huffman tree from the frequency table.
     *
     * @param array $frequency
     * @return Node The root of the Huffman tree.
     */
    private function buildHuffmanTree(array $frequency): Node
    {
        // Create a priority queue (min-heap) based on frequency
        $pq = new \SplPriorityQueue();
        $pq->setExtractFlags(\SplPriorityQueue::EXTR_DATA);

        foreach ($frequency as $char => $freq) {
            // Ensure $char is a string
            $char = (string)$char;
            // Since SplPriorityQueue is a max-heap, use negative frequency for min-heap behavior
            $pq->insert(new Node($char, $freq), -$freq);
        }

        // Edge case: Only one unique character
        if ($pq->count() === 1) {
            $onlyNode = $pq->extract();
            return new Node((string)$onlyNode->character, $onlyNode->frequency, $onlyNode, null);
        }

        // Build the Huffman tree
        while ($pq->count() > 1) {
            $left = $pq->extract();
            $right = $pq->extract();
            $merged = new Node('', $left->frequency + $right->frequency, $left, $right);
            $pq->insert($merged, -$merged->frequency);
        }

        return $pq->extract();
    }

    /**
     * Generates Huffman codes by traversing the tree.
     *
     * @param Node $node
     * @param string $prefix
     * @param array &$codes
     * @return void
     */
    private function generateCodes(Node $node, string $prefix, array &$codes): void
    {
        if ($node->isLeaf()) {
            // Edge case: If there's only one unique character, assign '0' as its code
            $codes[$node->character] = $prefix === '' ? '0' : $prefix;
            return;
        }

        if ($node->left !== null) {
            $this->generateCodes($node->left, $prefix . '0', $codes);
        }

        if ($node->right !== null) {
            $this->generateCodes($node->right, $prefix . '1', $codes);
        }
    }

    /**
     * Converts a bit string to a byte string.
     *
     * @param string $bits
     * @return string
     */
    private function bitsToBytes(string $bits): string
    {
        $bytes = '';
        $length = strlen($bits);
        for ($i = 0; $i < $length; $i += 8) {
            $byte = substr($bits, $i, 8);
            if (strlen($byte) < 8) {
                $byte = str_pad($byte, 8, '0'); // Pad with zeros if not enough bits
            }
            $bytes .= chr(bindec($byte));
        }
        return $bytes;
    }

    /**
     * Converts a byte string back to a bit string.
     *
     * @param string $bytes
     * @return string
     */
    private function bytesToBits(string $bytes): string
    {
        $bits = '';
        $length = strlen($bytes);
        for ($i = 0; $i < $length; $i++) {
            $bits .= str_pad(decbin(ord($bytes[$i])), 8, '0', STR_PAD_LEFT);
        }
        return $bits;
    }
}
