# Cookie Monster Secret Recipe

## Challenge

The challenge involves using the web developer console to inspect any fields related to web cookies and find the flag.

## Step 1: Inspect Developer Console

From the developer console, here is the request header when trying to attempt a login:

```
POST /login.php HTTP/1.1
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8
Accept-Encoding: gzip, deflate
Accept-Language: en-GB,en;q=0.5
Cache-Control: max-age=0
Connection: keep-alive
Content-Length: 21
Content-Type: application/x-www-form-urlencoded
Cookie: secret_recipe=cGljb0NURntjMDBrMWVfbTBuc3Rlcl9sMHZlc19jMDBraWVzX0E2RkEwN0Q4fQ%3D%3D
Host: verbal-sleep.picoctf.net:52021
Origin: http://verbal-sleep.picoctf.net:52021
Referer: http://verbal-sleep.picoctf.net:52021/
Sec-GPC: 1
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36
```

In particular, we should investigate the following field:

```
secret_recipe=cGljb0NURntjMDBrMWVfbTBuc3Rlcl9sMHZlc19jMDBraWVzX0E2RkEwN0Q4fQ%3D%3D
```

## Step 2: Dissecting the Cookie

Notice that the end of our secret recipe has ```%3D``` as an interesting observation at the end. This corresponds to the percent encoding of the equals sign. A list of common percent encodings can be found [here](https://en.wikipedia.org/wiki/Percent-encoding).

So in reality, we have this:

```
secret_recipe=cGljb0NURntjMDBrMWVfbTBuc3Rlcl9sMHZlc19jMDBraWVzX0E2RkEwN0Q4fQ==
```

Base 64 formats use ```=``` as padding at the end, so we can try a decoding out:

```bash
echo "cGljb0NURntjMDBrMWVfbTBuc3Rlcl9sMHZlc19jMDBraWVzX0E2RkEwN0Q4fQ==" | base64 -d
```

And the above command should give the flag.