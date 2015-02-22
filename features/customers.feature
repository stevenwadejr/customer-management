Feature: Customers
    In order to manage customers inside my application
    As an administrator
    I must be able to create, update, and delete customers

    Scenario: View Customer List
        When I go to "customers"
        Then I should see "Steven Wade"

    Scenario: Add new Customer
        When I add a new customer "John" "Doe"
        Then the url should match "customers"
        Then I should see "John Doe"

    Scenario: Update existing Customer
        When I update the last name of "1" to "Wade Jr"
        Then the url should match "customers"
        Then I should see "Steven Wade Jr"

    Scenario: Remove a Customer
        Given I am on "customers"
        Then I should see "2" customers
        And I delete the second customer
        Then I should see "1" customers

    Scenario: Merge duplicate Customers
        Given I am on "customers"
        Then I should see "2" customers
        And I merge duplicates
        Then I should see "1" customers