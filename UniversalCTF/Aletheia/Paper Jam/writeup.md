# Paper Jam

## Challenge

The goal of this challenge was to fix the corrupt file given as ```shipping_notice.pdf```, and proceed with the operation once the pdf was fixed.

## Step 1: Metadata Analysis

The first notable step that yielded some direction was getting the list of printable strings in the corrupt file:

``` bash
srch_strings shipping_notice.pdf > srch-strings.txt
```

And here is the first 30 lines of output:

```
%P0F-1.4
1 0 obj
<< /Type /Catalog /Pages 2 0 R >>
endobj
2 0 obj
<< /Type /Pages /Kids [3 0 R 6 0 R] /Count 2 >>
endobj
3 0 obj
<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>
endobj
4 0 obj
<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>
endobj
5 0 obj
<< /Length 331 >>
stream
/F1 16 Tf
72 725 Td
22 TL
(Recovered copier export from berth office scanner.) Tj
() Tj
(Maintenance note:) Tj
(  final export interrupted during writeout) Tj
(  page objects appear intact) Tj
(  document index and header likely damaged) Tj
() Tj
(Recover the file and inspect the final scanned page.) Tj
endstream
endobj
6 0 obj
```

The two damaged parts of the file are the header, and the document index, according to this message.

## Step 2: Fixing PDF Header

Notice that the header in this current document is incorrectly spelled:

```
%P0F-1.4
```

That ```0``` needs to be replaced with a ```D```, we can accomplish this uing a hex editor. For this problem, I used ```bvi``` to edit the hex characters, using a [hex to ascii converter](https://neapay.com/online-tools/hex-to-ascii-converter.html) to help with the process.

The result should yield the following:
the original -> 00000000: 2550 3046 2d31 2e34 0a25 e2e3 cfd3 0a31  %P0F-1.4.%.....1
the new header -> 00000000: 2550 4446 2d31 2e34 0a25 e2e3 cfd3 0a31  %PDF-1.4.%.....1

## Step 2: Creating Xref Table

Notice the output of ```exiftool``` once the header has been fixed:

```bash
exiftool shipping_notice.pdf
ExifTool Version Number         : 12.76
File Name                       : shipping_notice.pdf
Directory                       : .
File Size                       : 732 kB
File Modification Date/Time     : 2026:08:01 10:41:17-04:00
File Access Date/Time           : 2026:08:01 10:42:34-04:00
File Inode Change Date/Time     : 2026:08:01 10:41:17-04:00
File Permissions                : -rw-rw-r--
File Type                       : PDF
File Type Extension             : pdf
MIME Type                       : application/pdf
PDF Version                     : 1.4
Linearized                      : No
Warning                         : Invalid xref table
```

It says that the cross reference table is invalid, furthermore, its missing from the file based on the printable strings. We can use [Ghostscript](https://ghostscript.readthedocs.io/en/latest/index.html) to rewrite the file along with the xref table:

```
gs -o output.pdf -sDEVICE=pdfwrite shipping_notice.pdf
```

The above command device outputs the following and saves the newly written file to ```output.pdf```:

```
GPL Ghostscript 10.02.1 (2023-11-01)
Copyright (C) 2023 Artifex Software, Inc.  All rights reserved.
This software is supplied under the GNU AGPLv3 and comes with NO WARRANTY:
see the file COPYING for details.
Processing pages 1 through 2.
Page 1
Loading font Helvetica (or substitute) from /usr/share/ghostscript/10.02.1/Resource/Font/NimbusSans-Regular
Page 2

The following errors were encountered at least once while processing this file:
        no startxref token found
        xref table was repaired

The following warnings were encountered at least once while processing this file:
        bad trailer dictionary

   **** This file had errors that were repaired or ignored.
   **** Please notify the author of the software that produced this
   **** file that it does not conform to Adobe's published PDF
   **** specification.
```

Now that we have the repaired xref table, the flag is now visible in ```output.pdf```
