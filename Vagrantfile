# -*- mode: ruby -*-
# vi: set ft=ruby :

@script = <<SCRIPT
# Install php through apt-get - set the timezone
apt-get update
apt-get install -y php
sed -i 's#^;date\.timezone[[:space:]]=.*$#date.timezone = "America/Denver"#' /etc/php/7.2/cli/php.ini
SCRIPT

Vagrant.configure("2") do |config|
  config.vm.box = "hashicorp/bionic64"
  config.vm.synced_folder ".", "/calculator-problem"
  config.vm.provision 'shell', inline: @script
end
