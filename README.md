# Docker Workshop

![Containers](docker-intro-image.jpg)

## Prerequisites

To comfortably follow this workshop, we strongly suggest installing a virtualized environment with a Linux operating system inside. Here is a list of required software:

* [VirtualBox](https://www.virtualbox.org/) virtualization product
* [Ubuntu](https://ubuntu.com/) Linux
* VirtualBox [guest additions](https://linuxconfig.org/virtualbox-install-guest-additions-on-ubuntu-22-04-lts-jammy-jellyfish)

There is a slight chance that VirtualBox won't enable the virtualization support. Because of that, the Docker engine installed inside Ubuntu VM won't be able to start. To mitigate this, run the following command:

```bash
vboxmanage modifyvm VM_NAME --nested-hw-virt on
```


## Agenda

* [Intro to Containers](01_Intro_to_Containers)
* [The Linux Command Line](02_The_Linux_Command_Line)
* [Building images](03_Building_images)
* [Working with Containers](04_Working_with_Containers)
* [Running multi-container Applications](05_Running_multi-container_Applications)
* [Application deployment to AWS](06_Application_deployment_to_AWS)


## License

The unlicense. Please see the [License File](LICENSE) for more information.