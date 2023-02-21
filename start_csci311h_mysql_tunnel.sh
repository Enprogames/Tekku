#! /bin/bash

# 127.0.0.1 is localhost for IPv4 addresses. On my machine, if I don't
# include this, it tries to assign the IPv6 version (::1), which doesn't work
# on the CSCI server
ssh -N -L 127.0.0.1:3306:marie.csci.viu.ca:3306 csci311h@csci.viu.ca
