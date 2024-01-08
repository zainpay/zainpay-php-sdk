# Changelog

## [2.0.0] - 2024-01-01
## Changes
- added exception handling to allow user to access response object when statusCode is not 200 | OK

## [1.0.9] - 2023-11-06
## Changes
- added endpoints for getting card txn history by merchant or zainbox

## [1.0.8] - 2023-07-20
## Changes
- added payment channel to the filtering

## [1.0.7] - 2023-07-06
## Changes
- implemented filtering of transactions on txn endpoints

## [1.0.6] - 2023-06-07
## Changes
- updated zainbox creation and updation payload to include allowAutoInternalTransfer

## [1.0.5] - 2023-05-31
## Changes
- added optional parameter of setting count to endpoints for getting transactions list

## [1.0.4] - 2023-05-25
## Changes
- added v2 endpoint for deposit verification

## [1.0.3] - 2023-04-12
## Changes
- changed getData() return type from array to any on Response class

## [1.0.2] - 2023-02-23
## Changes
- fixed typos of all zainBoxCode to ZainboxCode
- added code 21 to the list of hasSucceeded function in Response 

## [1.0.1] - 2023-02-08
## Changes
- added mobileNumber to the virtual account payload and test
-added CHANGELOG.md file
