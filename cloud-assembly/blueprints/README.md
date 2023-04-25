# cloud-automation-samples

This section of code-assembly repository contains samples related to blueprints. 

Each folder must be defined as following

    |── Name                       # Name of the blueprint 
        ├── blueprint.yaml         # The YAML file that contains the code for the blueprint

The blueprint.yaml must have the following

    version: 1.0
    name: bp-tito-dockerhost
    
We have the following sample blueprints:

* DockerHost:      Blueprint to deploy a docker host
* TestRunner:      Blueprint to test Tito Application using Cypress and use Locus for load testing
* Tito:            Blueprint to deploy Tito Application
* TitoRoute53:     Blueprint to deploy Tito Application using AWS Route53 as Load Balancer
* WavefrontProxy:  Blueprint to deploy wavefront proxy
* PluginBasedDesign:
    * [v1]SimpleAwsInstance: Blueprint to deploy simple statically configured plug-in based AWS instance
    * [v2]InstanceWithComputeAllocation: Blueprint to deploy plug-in based AWS instance with dynamically configured
account, region and availability_zone using a Compute Allocation Helper
    * [v3]InstanceWithComputeFlavorImageAllocation: Blueprint to deploy plug-in based AWS instance with dynamically
configured account, region, availability_zone, instance_type and image_id using Compute, Flavor and Image Allocation
Helpers
    * [v4]InstanceWithComputeFlavorImageNetworkAllocation: Blueprint to deploy plug-in based AWS instance with
dynamically configured account, region, availability_zone, instance_type, image_id and subnet_id using Compute, Flavor,
Image and Network Allocation Helpers
    * [v5]DynamicallyConfiguredInstancesAndVolume: Blueprint to deploy two plug-in based AWS instances and a plug-in
based AWS volume, attached to one of the instances, all of which dynamically configured with the same Allocation Helpers
    * [v6]DynamicallyConfiguredInstancesVolumeAndKey: Blueprint to deploy two plug-in based AWS instances, a plug-in
based AWS volume, attached to one of the instances and encrypted with a "classic" KMS key, all of which dynamically
configured with the same Allocation Helpers
