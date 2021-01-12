# MiniAspire features

## Customers management 

**As a** a front-end developer,
**I want** to have the Customer CURD API **so that** I can list, create, edit, also delete the customer from my application.

**Acceptance Criteria**

* **[GET] /api/customers** with pagination to show customers list 
* **[POST] /api/customers** to create new customer with the payload structure as below
```
{
    "name" : "Customer name",
    "email" : "Customer email",
}
```
* **[GET] api/customers/{customer_id}** to show customer information based on {customer_id}
* **[PUT] api/customers/{customer_id}** to update customer information based on {customer_id} with the payload structure as below
```
{
    "name" : "Customer name",
    "email" : "Customer email",
}
```
* **[DELETE] api/customers/{customer_id}** to remove the customer based on {customer_id}


**Resources:**

* [Testing URL](http://localhost:8000/api/customers): http://localhost:8000/api/customers

## Loans management

**As a** a front-end developer,
**I want** to have the Loans API **so that** I can list, create, approve the loan for the customer from my application.

**Acceptance Criteria**

* **[GET] /api/loans** with pagination to show loans list 
* **[POST] /api/loans** to create new loans for the customer with the payload structure as below
```
{
    "customer_id": 3, // required|numeric|exists:customers,id
    "loan_term": 12, // required|integer|max:12
    "amount": 6000 //required|numeric|min:1000
}
```
* **[POST] /api/loans/{loan_id}/approve** to mark {loan_id} with status as approve 

**Resources:**

* [Testing URL](http://localhost:8000/api/loans): http://localhost:8000/api/loans

## Loan Repayment management

**As a** a front-end developer,
**I want** to have the Loan Repayment API **so that** I can perform the repay action which allow client can repay for their instalment

**Acceptance Criteria**

* **[PUT] /api/loan-repayments/{id}/repay** to send the repayment {id} repay request 
    **Asumption**:
    - Loans have "weekly" repayment frequency.
    - Used the straight line interest calculation to calculate the price for each cycles
    - Not including the interest rate, fees

**Resources:**

* [Testing URL](http://localhost:8000/api/loan-repayments): http://localhost:8000/api/loan-repayments