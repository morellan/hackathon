require 'rubygems'
require 'sinatra'
require 'sinatra/cross_origin'
require 'json'

configure do
	enable :cross_origin
end

get '/' do
	JSON.dump [
		{:id_persona => 1, :mac_address => '48:60:bc:73:c5:ca', :nickname => 'morellan', :avatar => 'url', :online => true},
		{:id_persona => 2, :mac_address => '00:0c:29:b6:f3:9e', :nickname => 'ameboide', :avatar => 'url', :online => true},
		{:id_persona => 3, :mac_address => '68:7f:74:1b:60:53', :nickname => 'amenandiel', :avatar => 'url', :online => false},
		{:id_persona => 4, :mac_address => 'e0:2a:82:dc:f1:a7', :nickname => 'daniel', :avatar => 'url', :online => true},
		{:id_persona => 5, :mac_address => 'f0:b4:79:19:fe:3c', :nickname => 'memo', :avatar => 'url', :online => false},
		{:id_persona => 6, :mac_address => '00:26:82:73:8b:7e', :nickname => 'vzurita', :avatar => 'url', :online => true},
	]
end

