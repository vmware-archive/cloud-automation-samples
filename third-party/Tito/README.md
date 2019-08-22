<!--
#
# VMware Tito Application Sample
# Author Vincent Meoc  - vmeoc@vmware.com
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
-->
![My image](https://vmeoc.github.io/vmeoc/TitoRoad.png)

Tito is  a sample multi tiers application used to showcase the various ways of deploying and running an app across multiple technologies such as VMware vRealize Automation, virtual machines, containers, Kubernetes, public cloud, PaaS, etc... etc... etc...

Tito is a super simple application:
* to make it easy to understand the code (and therefore modify it)
* developped with widely supported languages/framework (PHP, Bootstrap) 
* Running on a typical 3 Tiers architecture

What does the app do when running? 

> I thought most people are commuting pretty much everyday so I wrote a "Time Traffic Overview" app a.k.a Tito.
>Simply enter your home address, work address and regular time departure and it will give you a number of stats such as the duration for each day of the week, the total duration, per week, per month, etc...
>Beware, some of them are scary. 
>Have you ever calculated the amount of time in your life you will spend commuting? Here we go...

![My image](https://vmeoc.github.io/vmeoc/Result.png)

### App files structure

Tito is made of a simple index.php webpage providing the initial content, once the user has clicked on submit, form_result.php is triggered and will turn the inputs in the right format, ask Google on the duration, create some stats, display them, display a map, write the inputs in a DB. That's it!
The folder "Deployment" contain the various Infra as a code files to deploy the app.
The other folder are just css files, picture files and other stuff.

### App architecture
tito is a 3 Tier architecture. This vRealize Automation blueprint does a good job at showing the full application architecture
![My image](https://vmeoc.github.io/vmeoc/vRABlueprint.png)


### For more information

visit www.vmcloud.fr
