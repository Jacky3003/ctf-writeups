# RED

## Challenge

The goal is to figure out what hidden information is under a 128x128 whole image

## Step 1: File Metadata Analysis

The first step was to find out if the flag or any relevant information regarding the flag can be found under the following commands

``` sh
xxd $1 > xxd-out.txt
exiftool $1 > exif-out.txt
srch_strings $1 > srch-strings.txt
```

Since there was nothing too relevant, I decided to go with the next step.

## Step 2: Uncovering Least Significant Bits

We can use ```zsetg``` to uncover any hidden data on ```.png``` images. Here is that output.

```
meta Poem           .. text: "Crimson heart, vibrant and bold,\nHearts flutter at your sight.\nEvenings glow softly red,\nCherries burst with sweet life.\nKisses linger with your warmth.\nLove deep as merlot.\nScarlet leaves falling softly,\nBold in every stroke."

chunk:0:IHDR        .. file: Adobe Photoshop Color swatch, version 0, 128 colors; 1st RGB space (0), w 0x80, x 0x806, y 0, z 0; 2nd HSB space (1), w 0x100, x 0, y 0xff01, z 0xff

b1,r,lsb,xy         .. 
b1,r,msb,xy         .. 
b1,g,lsb,xy         .. 
b1,g,msb,xy         .. 
b1,b,lsb,xy         .. 
b1,b,msb,xy         .. 
b1,a,lsb,xy         .. 
b1,a,msb,xy         .. 
b1,rgb,lsb,xy       .. 
b1,rgb,msb,xy       .. 
b1,bgr,lsb,xy       .. 
b1,bgr,msb,xy       .. 
b1,rgba,lsb,xy      .. text: "cGljb0NURntyM2RfMXNfdGgzX3VsdDFtNHQzX2N1cjNfZjByXzU0ZG4zNTVffQ==cGljb0NURntyM2RfMXNfdGgzX3VsdDFtNHQzX2N1cjNfZjByXzU0ZG4zNTVffQ==cGljb0NURntyM2RfMXNfdGgzX3VsdDFtNHQzX2N1cjNfZjByXzU0ZG4zNTVffQ==cGljb0NURntyM2RfMXNfdGgzX3VsdDFtNHQzX2N1cjNfZjByXzU0ZG4zNTVffQ=="

b1,rgba,msb,xy      .. file: OpenPGP Public Key

b1,abgr,lsb,xy      .. 
b1,abgr,msb,xy      .. 
b2,r,lsb,xy         .. 
b2,r,msb,xy         .. 
b2,g,lsb,xy         .. text: "ET@UETPETUUT@TUUTD@PDUDDDPE"

b2,g,msb,xy         .. 
b2,b,lsb,xy         .. 
b2,b,msb,xy         .. 
b2,a,lsb,xy         .. 
b2,a,msb,xy         .. 
b2,rgb,lsb,xy       .. file: OpenPGP Secret Key

b2,rgb,msb,xy       .. 
b2,bgr,lsb,xy       .. 
b2,bgr,msb,xy       .. file: OpenPGP Public Key

b2,rgba,lsb,xy      .. file: OpenPGP Secret Key

b2,rgba,msb,xy      .. text: "CIkiiiII"

b2,abgr,lsb,xy      .. file: OpenPGP Secret Key

b2,abgr,msb,xy      .. text: "iiiaakikk"

b3,r,lsb,xy         .. 
b3,r,msb,xy         .. 
b3,g,lsb,xy         .. 
b3,g,msb,xy         .. 
b3,b,lsb,xy         .. 
b3,b,msb,xy         .. 
b3,a,lsb,xy         .. 
b3,a,msb,xy         .. 
b3,rgb,lsb,xy       .. 
b3,rgb,msb,xy       .. 
b3,bgr,lsb,xy       .. 
b3,bgr,msb,xy       .. 
b3,rgba,lsb,xy      .. 
b3,rgba,msb,xy      .. text: "#wb#wp#7p"

b3,abgr,lsb,xy      .. 
b3,abgr,msb,xy      .. text: "7r'wb#7p"

b4,r,lsb,xy         .. 
b4,r,msb,xy         .. 
b4,g,lsb,xy         .. 
b4,g,msb,xy         .. 
b4,b,lsb,xy         .. file: 0421 Alliant compact executable not stripped

b4,b,msb,xy         .. 
b4,a,lsb,xy         .. 
b4,a,msb,xy         .. 
b4,rgb,lsb,xy       .. 
b4,rgb,msb,xy       .. 
b4,bgr,lsb,xy       .. 
b4,bgr,msb,xy       .. 
b4,rgba,lsb,xy      .. 
b4,rgba,msb,xy      .. 
b4,abgr,lsb,xy      .. 
b4,abgr,msb,xy      ..                    
```

The interesting piece of information is the following output:

```
b1,rgba,lsb,xy      .. text: "cGljb0NURntyM2RfMXNfdGgzX3VsdDFtNHQzX2N1cjNfZjByXzU0ZG4zNTVffQ==cGljb0NURntyM2RfMXNfdGgzX3VsdDFtNHQzX2N1cjNfZjByXzU0ZG4zNTVffQ==cGljb0NURntyM2RfMXNfdGgzX3VsdDFtNHQzX2N1cjNfZjByXzU0ZG4zNTVffQ==cGljb0NURntyM2RfMXNfdGgzX3VsdDFtNHQzX2N1cjNfZjByXzU0ZG4zNTVffQ=="
```

It seems that we have a repeated base 64 string here, so in turn we can decode it:

```
echo "cGljb0NURntyM2RfMXNfdGgzX3VsdDFtNHQzX2N1cjNfZjByXzU0ZG4zNTVffQ=" | base64 -d
```

And the flag should be seen in clear.