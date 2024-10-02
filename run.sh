# Create directories
mkdir -p src/Integers/Signed
mkdir -p src/Integers/Unsigned
mkdir -p src/Floats
mkdir -p src/Strings

# Create class files for signed integers
touch src/Integers/Signed/Int8.php
touch src/Integers/Signed/Int16.php
touch src/Integers/Signed/Int32.php
touch src/Integers/Signed/Int64.php
touch src/Integers/Signed/Int128.php

# Create class files for unsigned integers
touch src/Integers/Unsigned/UInt8.php
touch src/Integers/Unsigned/UInt16.php
touch src/Integers/Unsigned/UInt32.php
touch src/Integers/Unsigned/UInt64.php
touch src/Integers/Unsigned/UInt128.php

# Create class files for floats
touch src/Floats/Float32.php
touch src/Floats/Float64.php
touch src/Floats/Float128.php

# Create class file for strings
touch src/Strings/StringType.php

# Initialize Git repository
git init
git add .
git commit -m "Initial directory structure and class files"
