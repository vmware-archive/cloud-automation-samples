# cloud-automation-samples

This section of code-assembly repository contains samples related to blueprints. 

Each folder must be defined as following

    |── Name                       # Name of the blueprint 
        ├── blueprint.yaml         # The YAML file that contains the code for the blueprint

The blueprint.yaml must have the following

    version: 1.0
    name: bp-tito-dockerhost
    
We have the following sample blueprints:

*  DockerHost:      Blueprint to deploy a docker host
*  TestRunner:      Blueprint to test Tito Application using Cypress and use Locus for load testing
*  Tito:            Blueprint to deploy Tito Application
*  TitoRoute53:     Blueprint to deploy Tito Application using AWS Route53 as Load Balancer
*  WavefrontProxy:  Blueprint to deploy wavefront proxy
