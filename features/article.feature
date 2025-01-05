# Learn how to get started with Behat and BDD on Behat's website:
# http://behat.org/en/latest/quick_start.html
Feature: Article management
  In order to manage articles
  As a user
  I want to perform CRUD operations on articles

  Scenario: Adding a new article
    Given I navigate to "/articles"
    When I press "Add new record"
    And I fill in with :
      | Title | New Article |
      | Content | This is the content of the new article |
    And I press "Save"
    Then I should see "New Article"
    And I should see "This is the content of the new article"
    But I should not see "New Vehicle"

#  Scenario: Viewing the list of articles
#    Given I am on "/articles"
#    Then I should see "New Article"
#
#  Scenario: Editing an article
#    Given I am on "/articles"
#    When I press "Edit"
#    When I fill in "Content" with "Updated content for the article"
#    And I press "Save"
#    Then I should see "Updated content for the article"
#
#  Scenario: Deleting an article
#    Given I am on "/articles"
#    When I press "Delete" for "New Article"
#    Then I should not see "New Article"
