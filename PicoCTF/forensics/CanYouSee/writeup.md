# CanYouSee

## Challenge

The goal is to find out where the flag is located within the zip file.

## Step 1: Metadata Analysis

I first looked at using ```exiftool``` to find out more about the zip file, in which I stumbled upon this field:

```
Zip File Name                   : ukn_reality.jpg
```

So I decided to rename the zip file to ```ukn_reality.jpg```, which did not show any meaningful results.

Then, I tried actually unzipping the file to find the actual JPEG file with the same name, heres the output of ```exiftool``` on that file:

```
ExifTool Version Number         : 12.76
File Name                       : ukn_reality.jpg
Directory                       : .
File Size                       : 2.3 MB
File Modification Date/Time     : 2024:02:15 17:40:21-05:00
File Access Date/Time           : 2026:08:17 10:19:11-04:00
File Inode Change Date/Time     : 2026:08:17 10:19:09-04:00
File Permissions                : -rw-r--r--
File Type                       : JPEG
File Type Extension             : jpg
MIME Type                       : image/jpeg
JFIF Version                    : 1.01
Resolution Unit                 : inches
X Resolution                    : 72
Y Resolution                    : 72
XMP Toolkit                     : Image::ExifTool 11.88
Attribution URL                 : cGljb0NURntNRTc0RDQ3QV9ISUREM05fYTZkZjhkYjh9Cg==
Image Width                     : 4308
Image Height                    : 2875
Encoding Process                : Baseline DCT, Huffman coding
Bits Per Sample                 : 8
Color Components                : 3
Y Cb Cr Sub Sampling            : YCbCr4:2:0 (2 2)
Image Size                      : 4308x2875
Megapixels                      : 12.4
```

## Step 2: Decoding the Flag

Notice the following attribution URL:

```
Attribution URL                 : cGljb0NURntNRTc0RDQ3QV9ISUREM05fYTZkZjhkYjh9Cg==
```

Like previous CTF challenges in PicoCTF, this is most likely a base 64 decoding of the flag, so we can use the following command below to show the flag in clear:

```
echo "cGljb0NURntNRTc0RDQ3QV9ISUREM05fYTZkZjhkYjh9Cg==" | base64 -d
```
