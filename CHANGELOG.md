# Changelog

## [3.2.4] - 2025-05-07
## Changes
- added endpoints for fetching and filtering settlement history for a zainbox

## [3.2.2] - 2024-12-25
## Changes
- updated card txn endpoint to accomodate filtering by email, status and txnRef
- removed endpoint for getting all card txn for a merchant
- updated documentation with the new card txn list response

## [3.2.1] - 2024-03-19
## Changes
- added endpoints for reconciling card and bank deposit

## [3.2.0] - 2024-03-05
## Changes
- updated composer dependency requirement to accomodate php8.1 and php8.2

## [3.0.1] - 2024-01-18
## Changes
- updated virtual account creation payload to accommodate bvn
- updated README 

## [2.0.1] - 2024-01-18
## Changes
- fixed payment collected summary by merchant
- added endpoint for repushing deposit transaction
- added repush deposit event to the documentation

## [2.0.0] - 2024-01-01
## Changes
- added exception handling to allow user to access response object when statusCode is not 200 | OK
- added error message to allow user get error description when the response has no body
- updated Documentation
- updated fund transfer to accomodate callbackUrl

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
