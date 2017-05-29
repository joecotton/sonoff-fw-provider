# sonoff-fw-provider
Pull the latest, or a specific version, of Sonoff firmware for OTA upgrades

Looks in the same directory as the php script for *.bin files and allows pulling by version number.

http://[host]/fw.php?v=5.1.3
or
http://[host]/fw.php?v=latest

For version-specific pull, file must have exactly 1 "version number" in the filename, and end in ".bin", such as sonoff-5.1.3.bin

Pseudo-version 'latest' will deliver the file with the largest version identifier, as understood by PHP's version_compare().

Non-numeric versions are also possible, but most follow the pattern "firmware-[version].bin", such as firmware-alt01.bin
