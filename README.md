# Ariablog

A dynamic pattern directed rapid development framework for php.

AriaBlog reached a stable 1.1 version now.

It is mainly a front end that is easy to exted or just transform in a simple static website. It has really low overhead, so you can even host it on a Raspberry Pi Zero is you want and it will run just fine.

You don't believe a Pi can serve a moderate traffic website ? Here is a benchmark of my Raspberry Pi B :

```
ab -c 6 -n 1000 http://192.168.59.100/AriaBlog/index.php?page=PageTest
This is ApacheBench, Version 2.3 <$Revision: 1757674 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 192.168.59.100 (be patient)
Completed 100 requests
Completed 200 requests
Completed 300 requests
Completed 400 requests
Completed 500 requests
Completed 600 requests
Completed 700 requests
Completed 800 requests
Completed 900 requests
Completed 1000 requests
Finished 1000 requests


Server Software:        nginx/1.10.3
Server Hostname:        192.168.59.100
Server Port:            80

Document Path:          /AriaBlog/index.php?page=PageTest
Document Length:        6144 bytes

Concurrency Level:      6
Time taken for tests:   7.801 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      6449000 bytes
HTML transferred:       6144000 bytes
Requests per second:    128.19 [#/sec] (mean)
Time per request:       46.805 [ms] (mean)
Time per request:       7.801 [ms] (mean, across all concurrent requests)
Transfer rate:          807.33 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
              Connect:        2    6   3.8      5      32
              Processing:    24   41  20.0     38     267
              Waiting:       21   38  19.8     35     264
              Total:         27   47  20.3     43     284
              
              Percentage of the requests served within a certain time (ms)
                50%     43
                66%     48
                75%     51
                80%     53
                90%     59
                95%     64
                98%     73
                99%     87
               100%    284 (longest request)
```

A Pi Zero should be able to serve about 40 requests per second, which is fine for a low traffic website.