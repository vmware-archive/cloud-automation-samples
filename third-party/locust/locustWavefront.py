
# VMware Tito Application Test Sample
#
# Copyright 2019 VMware, Inc. All rights reserved
#
# The BSD-2 license (the "License") set forth below applies to all parts of the
# Cloud-automation-samples Code project. You may not use this file except in compliance
# with the License.
#
# BSD-2 License
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions are met:
#
# Redistributions of source code must retain the above copyright notice, this
# list of conditions and the following disclaimer.
# 
# Redistributions in binary form must reproduce the above copyright notice,
# this list of conditions and the following disclaimer in the documentation
# and/or other materials provided with the distribution.
# 
# THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
# AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
# LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
# CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
# SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
# INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
# CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
# ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
# POSSIBILITY OF SUCH DAMAGE.


from locust import HttpLocust, TaskSet, task
import resource
import locust.events
import time
import socket
import atexit
import os
import gevent
from gevent.coros import RLock

lock = RLock()
resource.setrlimit(resource.RLIMIT_NOFILE, (999999, 999999))

# Wavefront metric format
# <metricName> <metricValue> [<timestamp>] source=<source> [pointTags]
# Note: This python script assumes the environemnt variable WAVEFRONT_PROXY has been set prior to execution

class Tito(TaskSet):
    @task
    def open_index_page(self):
        self.client.get("/Tito/")

class MyLocust(HttpLocust):
    task_set = Tito
    sock = None

    def __init__(self):
        super(MyLocust, self).__init__()
        self.sock = socket.socket()
        wavefrontProxy = os.environ.get("WAVEFRONT_PROXY")
        self.sock.connect( (wavefrontProxy, 2878) )
        locust.events.request_success += self.hook_request_success
        locust.events.request_failure += self.hook_request_fail
        atexit.register(self.exit_handler)

    def hook_request_success(self, request_type, name, response_time, response_length):
        myHost = self.host
        myHost = myHost.replace("http://","")
        met_locustRequest = 'locust.response.success' + ' ' + str(response_time) + ' ' + str(time.time()) + ' ' + 'source=' + myHost + ' ' + 'app=Tito' + ' \n'
        self.sock.sendall(met_locustRequest.encode('utf-8'))
        #print(met_locustRequest)

    def hook_request_fail(self, request_type, name, response_time, exception):
        myHost = self.host
        myHost = myHost.replace("http://","")
        met_locustRequestFailed = 'locust.response.failed' + ' ' + str(response_time) + ' ' + str(time.time()) + ' ' + 'source=' + myHost + ' ' + 'app=Tito' + ' \n'
        self.sock.sendall(met_locustRequestFailed.encode('utf-8'))
        #print(met_locustRequestFailed)

    def exit_handler(self):
        try:
            self.sock.shutdown(socket.SHUT_RDWR)
        except IOError:
            # Don't be surprised if the socket is in "not
            # connected" state.
            pass
        else:
            self.sock.close()