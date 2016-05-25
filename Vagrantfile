require 'json'
require 'yaml'

VAGRANTFILE_API_VERSION ||= "2"
confDir = $confDir ||= File.expand_path("vendor/laravel/homestead", File.dirname(__FILE__))

homesteadYamlPath = "Homestead.yaml"
homesteadJsonPath = "Homestead.json"
afterScriptPath = "after.sh"
aliasesPath = "aliases"

require File.expand_path(confDir + '/scripts/homestead.rb')

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  if File.exists? aliasesPath then
    config.vm.provision "file", source: aliasesPath, destination: "~/.bash_aliases"
  end

  if File.exists? homesteadYamlPath then
    homesteadConfig = YAML::load(File.read(homesteadYamlPath))
    Homestead.configure(config, homesteadConfig)
  elsif File.exists? homesteadJsonPath then
    homesteadConfig = JSON.parse(File.read(homesteadJsonPath))
    Homestead.configure(config, homesteadConfig)
  end

  aliases = []
  homesteadConfig['sites'].each do |site|
    aliases.push(site['map'])
  end

  if Vagrant.has_plugin? 'vagrant-hostmanager' then
    config.hostmanager.enabled = true
    config.hostmanager.manage_host = true
    config.hostmanager.aliases = aliases
  else
    fail_with_message "vagrant-hostmanager missing, please install the plugin with this command:\nvagrant plugin install vagrant-hostmanager"
  end

  if File.exists? afterScriptPath then
    config.vm.provision "shell", path: afterScriptPath
  end
end

def fail_with_message(msg)
  fail Vagrant::Errors::VagrantError.new, msg
end
