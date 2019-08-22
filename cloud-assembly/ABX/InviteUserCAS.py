#
# VMware Cloud Automation Actions Sample
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
#
from botocore.vendored import requests
import json

def handler(context, inputs):

    def invite(header,
               id,
               usernames,
               org_role='org_member',
               cloud_assembly=False,
               code_stream=False,
               service_broker=False,
               log_intelligence=False,
               network_insight=False
               ):
        baseurl = 'https://console.cloud.vmware.com'
        uri = f'/csp/gateway/am/api/orgs/{id}/invitations'
        payload = {
            'usernames': usernames,
            'orgRoleName': org_role,
            'serviceRolesDtos': []
        }
        if cloud_assembly:
            payload['serviceRolesDtos'].append({
                'serviceDefinitionLink': ('/csp/gateway/slc/api/definitions'
                                          '/external'
                                          '/Zy924mE3dwn2ASyVZR0Nn7lupeA_'
                                          ),
                'serviceRoleNames':
                    [
                        'automationservice:user',
                        'automationservice:cloud_admin'
                    ]
            })

        if code_stream:
            payload['serviceRolesDtos'].append({
                'serviceDefinitionLink': ('/csp/gateway/slc/api/definitions'
                                          '/external'
                                          '/ulvqtN4141beCT2oOnbj-wlkzGg_'
                                          ),
                'serviceRoleNames':
                    [
                        'CodeStream:administrator',
                        'CodeStream:viewer',
                        'CodeStream:developer'
                    ]
            })

        if service_broker:
            payload['serviceRolesDtos'].append({
                'serviceDefinitionLink': ('/csp/gateway/slc/api/definitions'
                                          '/external'
                                          '/Yw-HyBeQzjCXkL2wQSeGwauJ-mA_'
                                          ),
                'serviceRoleNames':
                [
                    'catalog:admin',
                    'catalog:user'
                ]
            })

        if log_intelligence:
            payload['serviceRolesDtos'].append({
                'serviceDefinitionLink': ('/csp/gateway/slc/api/definitions'
                                          '/external'
                                          '/7cJ2ngS_hRCY_bIbWucM4KWQwOo_'
                                          ),
                'serviceRoleNames':
                    [
                        'log-intelligence:admin',
                        'log-intelligence:user'
                    ]
            })

        if network_insight:
            payload['serviceRolesDtos'].append({
                'serviceDefinitionLink': ('/csp/gateway/slc/api/definitions'
                                          '/external'
                                          '/9qjoNafDp9XkyyQLcLCKWPsAir0_'
                                          ),
                'serviceRoleNames':
                    [
                        'vrni:admin',
                        'vrni:user'
                    ]
            })
        url = baseurl + uri
        print(url)
        print(payload)
        return requests.post(url,json=payload,headers=header)
    
    
    baseUri = inputs['baseUri']
    casToken = inputs['casToken']
    
    url = baseUri + "/csp/gateway/am/api/auth/api-tokens/authorize?refresh_token=" + casToken
    headers = {"Accept":"application/json","Content-Type":"application/json"}
    payload = {}

    results = requests.post(url,json=payload,headers=headers)
    
    print(results.json()["access_token"])
    bearer = "Bearer "
    bearer = bearer + results.json()["access_token"]
    headers = {"Accept":"application/json","Content-Type":"application/json", "Authorization":bearer, 'csp-auth-token':results.json()["access_token"] }
    
    results = invite( header=headers,
                      id=inputs['orgId'],
                      usernames=inputs['usernames'],
                      cloud_assembly=True,
                      code_stream=True,
                      service_broker=True)
    

    print(results)

    