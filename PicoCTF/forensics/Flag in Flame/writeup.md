# Flag in Flame

## Challenge

The goal of this challenge is to find out the hidden secret within the ```log.txt``` file in order to uncover the flag.

## Step 1: Metadata Analysis

Here are the following shell commands that we can use to analyze the metadata for the file:

```sh
xxd $1 > xxd-out.txt
exiftool $1 > exif-out.txt
srch_strings $1 > srch-strings.txt
```

Here, we can see that our single line of strings seems to represent a base 64 encoding, so we can do the following to the log file:

```sh
cat logs.txt | base64 -d > decoded.txt
```

We can then do an extra metadata analysis on the decoded text file, and the first line of ```xxd``` gives an interesting piece of information:

```
00000000: 8950 4e47 0d0a 1a0a 0000 000d 4948 4452  .PNG........IHDR
```

It seems like the header is png related, which means that we can change our file to ```.png``` and see an image.

## Step 2: Image Observations

The image itself has a large string at the bottom:
```
"7069636F4354467B666F72656E736963735F616E616C797369735F69735F616D617A696E675F32353631613139347D"
```

This string format seems to be base 16 related, or a hex encoding. We can then try to decode the hex using the following command:

```
echo <our-large-string> | xxd -r -ps
```

And the above command should result in getting the flag.
