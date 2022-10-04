Feature: Creating a carrier
  In order to ship products to our customers
  As a business
  We need to be able to create carriers

  Scenario: Creating a carrier
    Given a carrier called "Agro" does not exist
    When I create a carrier called "Agro"
    Then a carrier called "Agro" exists

  Scenario: Creating a duplicate carrier
    Given a carrier called "Agro" already exists
    When I create a carrier called "Agro"
    Then a carrier called "Agro" exists
    And the duplicate carrier is ignored
