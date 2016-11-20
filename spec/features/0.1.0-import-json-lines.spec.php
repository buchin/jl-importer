<?php
use Buchin\Jl\Importer;
use RedBeanPHP\R;

describe('0.1.0 - Feature: Import Json lines', function(){
	context('User story:', function(){
		describe('As a user', function(){});
		describe('I want to import Json lines file into database', function(){});
		describe('So I can create millions of contents automatically', function(){});
	});

	context('Scenario:', function(){

		given('importer', function(){
			return new Importer;
		});
		describe('User import file programmatically', function(){
			context('when source file not exists', function(){
				it('return false and abort import', function(){
					allow($this->importer)->toReceive('setSource')->andReturn(false);
					expect($this->importer->import('source', 'dest'))->toBeFalsy();
				});
			});

			context('when database connection problem occured', function(){
				it('return false and abort import', function(){
					allow($this->importer)->toReceive('setSource')->andReturn(true);
					allow($this->importer)->toReceive('setR')->andReturn(false);
					expect($this->importer->import('source', 'dsn'))->toBeFalsy();
				});
			});

			context('when source file exists & db connect', function(){

				it('import json line file into database', function(){
					$dsn = "mysql:unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock;dbname=test";

					$source = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'examples' . DIRECTORY_SEPARATOR . 'sample.jl';
					expect($this->importer->import($source, $dsn, 'root', 'root'))->toBeTruthy();
					expect(R::count('usaha'))->toBe(10);
					R::wipe('usaha');
				});
			});
			
		});
	});
});