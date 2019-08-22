#main config for AWS provider
variable "aws_region" {
  description = "Default AWS provider region"
  default = "us-west-1"
}

# main creds for AWS connection
variable "aws_access_key_id" {
  description = "AWS access key"
}

variable "aws_secret_access_key" {
  description = "AWS secret access key"
}

variable "availability_zone" {
  description = "availability zone used for the demo, based on region"
  default = {
    us-east-1 = "us-east-1a"
  }
}

########################### dev VPC Config ##################################

variable "vpc_name" {
  description = "VPC for building dev env"
  default ="DevTerraformVPC"
}

variable "vpc_region" {
  description = "AWS region"
  default = "us-east-1"
}

variable "vpc_cidr_block" {
  description = "Uber IP addressing for dev Network"
  default = "10.194.0.0/16"
}

variable "vpc_public_subnet_cidr" {
  description = "Public 0.0 CIDR for externally accessible subnet"
  default= "10.194.10.0/24"
}


variable "vpc_private_subnet_cidr" {
  description = "Private CIDR for internally accessible subnet"
  default= "10.194.20.0/24"
}

variable "vpc_access_from_ip_range" {
  description = "Private CIDR for internally accessible subnet"
  default= "0.0.0.0/0"
}
