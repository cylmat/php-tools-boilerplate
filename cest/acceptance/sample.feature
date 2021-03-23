@sample_group
Feature: sample
  In order to test home page
  As a developer
  I need to see the server output

  Scenario: see index page
    Given i am on the home page
      | sample | test |
    When i read the output
    Then i should see the server data
"""
  sample
"""
