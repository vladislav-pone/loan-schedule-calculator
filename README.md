# Loan Schedule Calculator API
## About
Loan schedule API in PHP that creates a Loan entity, calculates and returns a collection of payment segments
## What it is in details
### Terminology
* Principal: The principal loan amount. Within app in cents.
* Term: The loan term. Within app in months.
* Segment: Month number within term.
* Interest Rate: Rate on calculating profit for loan lender. It is calculated each month based on initial principal and generaly does not changes over tyme. Within app in Basis points.
* Euribor Rate: Rate on calculating cross bank interest rate. It is calculated each month based on principal that is left to be paid and changes every sergment. Within app in Basis points.
* Basis Points: A rate measurement unit. 1 basis point = 0.01%.
### Methodology
With an API request you can specify principal, term, interest rate and initial euribor rate and get back json with total payment broken down in details. This data could be used to easily check payment scedule for future loans.

Additionally, response has loan id, which you can later use to adjust euribor rate per segment.

App uses annuity formula to evenly split principal payments and interest payments across segments. Euribor is applied afterwards per segment to calculate each payment.

### Installation
1. Clone project 
2. `make build` should do the trick
### Useful commands
* `make` command could help with CLI 
* `make test` command could help verify that project was installed correctly
### API Requests and Responses
>  Note: all request params are non-negative integers
#### POST `/api/loans`
*Used to create new loan calculation record.*

Request
```
amount_in_cents
term
interest_rate_in_basis_points
euribor_rate_in_basis_points
```
Response
```json
{
    "loanId": 1,
    "schedule": [
        [
            "segment" => 0
            "principalPaymentInCents" => 0
            "interestPaymentInCents" => 0
            "euriborPaymentInCents" => 0
            "totalPaymentInCents" => 0
        ],
        [...]
    ]
}
```
#### POST `/api/loans/1`
*Used to adjust euribor rate. Can be used multiple times changing different segments or update previous record. Last change takes effect. Euribor rate takes effect on __selected segment and all following sergments.__*

Request
```
segment_nr
euribor_in_basis_point
```
Response
```json
[
    [
        "segment" => 0
        "principalPaymentInCents" => 0
        "interestPaymentInCents" => 0
        "euriborPaymentInCents" => 0
        "totalPaymentInCents" => 0
    ],
    [...]
]
```
#### GET `/api/loans/1`
*Used to view previously generated loan.*

Response
```json
[
    [
        "segment" => 0
        "principalPaymentInCents" => 0
        "interestPaymentInCents" => 0
        "euriborPaymentInCents" => 0
        "totalPaymentInCents" => 0
    ],
    [...]
]
```

### Examples
#### Without Euribor adjustments
If we send following request:
```
amount_in_cents = 1000000
term = 12
interest_rate_in_basis_points = 400
euribor_rate_in_basis_points = 394
```
API should return following data:
| segment # | principalPaymentInCents | interestPaymentInCents | euriborPaymentInCents | totalPaymentInCents |
|-----------|------------------------|------------------------|-----------------------|---------------------|
| 1         | 81817                  | 3333                   | 3283                  | 88433               |
| 2         | 82089                  | 3061                   | 3015                  | 88165               |
| 3         | 82363                  | 2787                   | 2745                  | 87895               |
| 4         | 82638                  | 2512                   | 2475                  | 87625               |
| 5         | 82913                  | 2237                   | 2203                  | 87353               |
| 6         | 83189                  | 1961                   | 1931                  | 87081               |
| 7         | 83467                  | 1683                   | 1658                  | 86808               |
| 8         | 83745                  | 1405                   | 1384                  | 86534               |
| 9         | 84024                  | 1126                   | 1109                  | 86259               |
| 10        | 84304                  | 846                    | 833                   | 85983               |
| 11        | 84585                  | 565                    | 556                   | 85706               |
| 12        | 84867                  | 283                    | 279                   | 85429               |


#### With Euribor adjustment
If we send following request:
```
amount_in_cents = 1000000
term = 12
interest_rate_in_basis_points = 400
euribor_rate_in_basis_points = 394
```
```
segment_nr = 6
euribor_in_basis_point = 410
```
API should return following data:

| segmentNumber | principalPaymentInCents | interestPaymentInCents | euriborPaymentInCents | totalPaymentInCents |
|---------------|-------------------------|------------------------|-----------------------|---------------------|
| 1             | 81817                   | 3333                   | 3283                  | 88433               |
| 2             | 82089                   | 3061                   | 3015                  | 88165               |
| 3             | 82363                   | 2787                   | 2745                  | 87895               |
| 4             | 82638                   | 2512                   | 2475                  | 87625               |
| 5             | 82913                   | 2237                   | 2203                  | 87353               |
| 6             | 83189                   | 1961                   | 2010                  | 87160               |
| 7             | 83467                   | 1683                   | 1725                  | 86875               |
| 8             | 83745                   | 1405                   | 1440                  | 86590               |
| 9             | 84024                   | 1126                   | 1154                  | 86304               |
| 10            | 84304                   | 846                    | 867                   | 86017               |
| 11            | 84585                   | 565                    | 579                   | 85729               |
| 12            | 84867                   | 283                    | 290                   | 85440               |
