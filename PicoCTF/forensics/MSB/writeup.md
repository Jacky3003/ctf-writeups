# MSB

## Challenge

The goal here is to use the knowledge that the file has some secret information that can be uncovered from the most significant bits of its color channels.

## Step 1: Uncovering The Bits

We can use ```zsteg``` to run an automated most significant or least significant bit analysis on the given file:

```bash
zsteg Ninja-and-Prince-Genji-Ukiyoe-Utagawa-Kunisada.flag.png

# output
imagedata           .. text: "~~~|||}}}"
chunk:0:IHDR        .. file: Adobe Photoshop Color swatch, version 0, 1074 colors; 1st RGB space (0), w 0x5dc, x 0x802, y 0, z 0; 2nd space (32768), w 0x8000, x 0x8080, y 0x80, z 0
b1,g,lsb,xy         .. file: Common Data Format (Version 2.5 or earlier) data
b1,g,msb,xy         .. file: Common Data Format (Version 2.5 or earlier) data
b2,r,lsb,xy         .. text: ["U" repeated 8 times]
b2,g,lsb,xy         .. file: Matlab v4 mat-file (little endian) \252\252\252\252\252\252\252\252, numeric, rows 4294967295, columns 4294967295
b2,g,msb,xy         .. file: Matlab v4 mat-file (little endian) UUUUUUUU, numeric, rows 4294967295, columns 4294967295
b2,b,lsb,xy         .. text: ["U" repeated 8 times]
b4,r,lsb,xy         .. text: ["w" repeated 8 times]
b4,r,msb,xy         .. text: ["U" repeated 12 times]
b4,g,msb,xy         .. text: ["w" repeated 16 times]
b4,b,lsb,xy         .. text: "\"\"\"\"\"\"\"\"4DC\""
b4,b,msb,xy         .. text: "wwwwwwww3333"
```

# Step 2: Customizing Zsteg

There does not seem to be an exact answer to where the flag could be, so lets customize what we want from ```zsteg``` to get a more exact answer:

```
zsteg -b 10000000 -E "b10000000,rgb,lsb,xy" Ninja-and-Prince-Genji-Ukiyoe-Utagawa-Kunisada.flag.png > zstegsigbits.txt
```

Here is a breakdown:
- ```-b``` is to specify the bit string to use for MSB or LSB
- ```-E``` is used to extract the file given on the particular option, the ```lsb``` part is to show that the bit string is used relative to the ordering of the least significant bit
- Then we have an output stream at the end that gives our output.

The command above should reveal the flag that is somewhere inside ```zstegbits.txt```
