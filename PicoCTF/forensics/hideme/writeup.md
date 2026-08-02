# hideme

## Challenge

The goal is to find out what secret is being kept within the ```flag.png``` image given in the challenge.

## Step 1: Investigating File Data and Metadata

The first warning that I noticed when inspecting this file is that it gave the following warning when ran under ```exiftool```

```
ExifTool Version Number         : 12.76
File Name                       : flag.png
Directory                       : .
File Size                       : 43 kB
File Modification Date/Time     : 2026:08:02 15:49:45-04:00
File Access Date/Time           : 2026:08:02 15:50:49-04:00
File Inode Change Date/Time     : 2026:08:02 15:50:27-04:00
File Permissions                : -rw-rw-r--
File Type                       : PNG
File Type Extension             : png
MIME Type                       : image/png
Image Width                     : 512
Image Height                    : 504
Bit Depth                       : 8
Color Type                      : RGB with Alpha
Compression                     : Deflate/Inflate
Filter                          : Adaptive
Interlace                       : Noninterlaced
Warning                         : [minor] Trailer data after PNG IEND chunk
Image Size                      : 512x504
Megapixels                      : 0.258
```

In this file, it seems like there is more data after the IEND chunk, so this is what that looks like under ```xxd```:

```
00009b30: 0000 0049 454e 44ae 4260 8250 4b03 040a  ...IEND.B`.PK...
00009b40: 0000 0000 003c 1070 5600 0000 0000 0000  .....<.pV.......
00009b50: 0000 0000 0007 001c 0073 6563 7265 742f  .........secret/
00009b60: 5554 0900 0393 7812 6493 7812 6475 780b  UT....x.d.x.dux.
00009b70: 0001 0400 0000 0004 0000 0000 504b 0304  ............PK..
```

## Step 2: Removing the Data

After playing around with the IEND hex digits (where ```.png``` images always end with ```4945 4e44 ae42 6082``` as the last part of their hex digits), I decided to skip all of the bytes relevant to the ```flag.png``` image. I created an output file where the hex dump started with ```50 4b03 040a```. This can be accomplished by skipping a set amount of bytes with ```dd```:

```
dd if=flag.png of=output.png bs=1 skip=39739
```

The output file then showed the following when ran under ```exiftool```:

```
ExifTool Version Number         : 12.76
File Name                       : output.png
Directory                       : .
File Size                       : 3.2 kB
File Modification Date/Time     : 2026:08:02 16:25:13-04:00
File Access Date/Time           : 2026:08:02 16:26:09-04:00
File Inode Change Date/Time     : 2026:08:02 16:25:41-04:00
File Permissions                : -rw-rw-r--
File Type                       : ZIP
File Type Extension             : zip
MIME Type                       : application/zip
Zip Required Version            : 10
Zip Bit Flag                    : 0
Zip Compression                 : None
Zip Modify Date                 : 2023:03:16 02:01:56
Zip CRC                         : 0x00000000
Zip Compressed Size             : 0
Zip Uncompressed Size           : 0
Zip File Name                   : secret/
Warning                         : [minor] Use the Duplicates option to extract tags for all 2 files
```

Since the file was a ZIP file, I unzipped the file after renaming it with ```.zip``` and the flag was found within the files unzipped.

