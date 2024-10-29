<?php

declare(strict_types=1);

namespace Nejcc\PhpDatatypes\Encoding;

/**
 * Class Node
 * Represents a node in the Huffman tree.
 */
class Node
{
    public string $character;
    public int $frequency;
    public ?Node $left;
    public ?Node $right;

    public function __construct(string $character, int $frequency, ?Node $left = null, ?Node $right = null)
    {
        $this->character = $character;
        $this->frequency = $frequency;
        $this->left = $left;
        $this->right = $right;
    }

    /**
     * Check if the node is a leaf node.
     *
     * @return bool
     */
    public function isLeaf(): bool
    {
        return is_null($this->left) && is_null($this->right);
    }
}
