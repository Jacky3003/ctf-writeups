# Like1000

## Challenge

The challenge gives a single ```.tar``` file that has something to do with the flag.

## Step 1. Investigate Tar File

The first thing that I did was to use ```binwalk``` to check for any hidden files:

```bash
binwalk -e 1000.tar
```

The extraction folder gave two files, a ```filler.txt``` file which told nothing, and another tar file called ```999.tar```.

If ```binwalk``` is used on this new ```.tar``` file, we get another ```.tar``` file named ```998.tar```.

## Step 2. Automating the Process

Clearly, there seems to be a pattern here, where the file ```1.tar``` may have some sort of answer to get a flag. Instead of manually doing ```binwalk``` each time, we can script it instead:

```sh
i=1000
while [ "$i" -ge 1 ]; do
    binwalk -e "$i.tar"

    if [ ! -f "extractions/$i.tar.extracted/0/$((i - 1)).tar" ]; then
        echo "File $((i - 1)).tar not found. Breaking loop."
        break
    fi

    mv "extractions/$i.tar.extracted/0/$((i - 1)).tar" .

    rm "$i.tar"
    rm -r extractions
    i=$((i - 1))
done
```

What this script does:
- It first starts at i = 1000, and enters the loop to binary walk the next ```i.tar``` file.
- If for some reason, there is no ```.tar``` file anymore, we do a conditional check on the extraction and break the loop early.
- If there is, we move the ```(i-1).tar``` file to the current directory, remove the old ```i.tar``` file, and remove the extractions folder for the binary walk on the next iteration.

Running this script should show the flag in the final extractions directory, as a ```.png``` file in clear.