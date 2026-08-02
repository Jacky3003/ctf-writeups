# Corrupted File

## Challenge

The goal here is to see what is corrupting the file based on some of the data and metadata that we can extract from the file.

## Step 1: Finding Out Issues

On the first run of ```exiftool``` on the file, we get the following:

```
ExifTool Version Number         : 12.76
File Name                       : file
Directory                       : .
File Size                       : 8.8 kB
File Modification Date/Time     : 2026:08:02 15:29:22-04:00
File Access Date/Time           : 2026:08:02 15:31:12-04:00
File Inode Change Date/Time     : 2026:08:02 15:30:49-04:00
File Permissions                : -rw-rw-r--
Error                           : Unknown file type
```

The first line of ```xxd``` on the file gives the following:

```
00000000: 5c78 ffe0 0010 4a46 4946 0001 0100 0001  \x....JFIF......
```

Notice that this almost matches a sample header for normal ```.jpg``` files, but some of the characters are different:

```
00000000: ffd8 ffe0 0010 4a46 4946 0001 0101 0048  ......JFIF.....H
```

## Step 2: Replacing the Digits

We can use ```bvi``` on the file to replace the digits, which will now give us a new header:

```
00000000: ffd8 ffe0 0010 4a46 4946 0001 0100 0001  ......JFIF......
```

## Step 3: Renaming File

Now we can try using ```exiftool``` again:

```
ExifTool Version Number         : 12.76
File Name                       : file
Directory                       : .
File Size                       : 8.8 kB
File Modification Date/Time     : 2026:08:02 15:37:37-04:00
File Access Date/Time           : 2026:08:02 15:37:41-04:00
File Inode Change Date/Time     : 2026:08:02 15:37:37-04:00
File Permissions                : -rw-rw-r--
File Type                       : JPEG
File Type Extension             : jpg
MIME Type                       : image/jpeg
JFIF Version                    : 1.01
Resolution Unit                 : None
X Resolution                    : 1
Y Resolution                    : 1
Image Width                     : 800
Image Height                    : 500
Encoding Process                : Baseline DCT, Huffman coding
Bits Per Sample                 : 8
Color Components                : 3
Y Cb Cr Sub Sampling            : YCbCr4:2:0 (2 2)
Image Size                      : 800x500
Megapixels                      : 0.400
```

And we can see that our file type is a JPEG file, and if we rename the file with ```.jpg``` at the end, we get the flag in clear.


