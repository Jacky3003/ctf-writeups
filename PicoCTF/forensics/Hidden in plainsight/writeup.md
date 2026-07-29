# Hidden in plainsight

## Challenge

Goal is to find out the hidden aspect for the given image file, and look into decoding the hidden message given the small hints.

## Step 1: File Analysis

Here are the following 3 shell commands that were used to extract information out of ```img.jpg```, where the former file is passed in as the first argument:

```sh
xxd $1 > xxd-out.txt

exiftool $1 > exif-out.txt

srch_strings $1 > srch-strings.txt
```

In the output of ```exiftool```, we have the following:

```
ExifTool Version Number         : 12.76
File Name                       : img.jpg
Directory                       : .
File Size                       : 74 kB
File Modification Date/Time     : 2026:07:28 16:00:36-04:00
File Access Date/Time           : 2026:07:28 16:01:08-04:00
File Inode Change Date/Time     : 2026:07:28 16:00:51-04:00
File Permissions                : -rw-rw-r--
File Type                       : JPEG
File Type Extension             : jpg
MIME Type                       : image/jpeg
JFIF Version                    : 1.01
Resolution Unit                 : None
X Resolution                    : 1
Y Resolution                    : 1
Comment                         : c3RlZ2hpZGU6Y0VGNmVuZHZjbVE9
Image Width                     : 640
Image Height                    : 640
Encoding Process                : Baseline DCT, Huffman coding
Bits Per Sample                 : 8
Color Components                : 3
Y Cb Cr Sub Sampling            : YCbCr4:2:0 (2 2)
Image Size                      : 640x640
Megapixels                      : 0.410
```

The ```Comment``` field seems to have an interesting value.

## Step 2: Base64 Encoding

The value of ```Comment``` from before looks to be a [base64 encoding](https://developer.mozilla.org/en-US/docs/Glossary/Base64), so we can decode it to see what we get:

```sh
echo "c3RlZ2hpZGU6Y0VGNmVuZHZjbVE9" | base64 -d
steghide:cEF6endvcmQ=
echo "cEF6endvcmQ=" | base64 -d
pAzzword
```

In fact, we can do two decodings to find out that the ```steghide``` password is ```pAzzword```.

## Step 3: Finding the Flag

We should then be able to enter in the found password for ```steghide```:

```sh
steghide extract -sf img.jpg 
```

The flag will be written to ```flag.txt```
