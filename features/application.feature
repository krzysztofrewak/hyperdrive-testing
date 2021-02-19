Feature: Check application behaviour

  Background:
    Given there's an route built from array:
      | route      | planets              |
      | Kessel Run | Formos, Rion, Kessel |
    And given route is mounted in a navigator instance

  Scenario:
    When "Kessel" is first selected planet
    Then current planet should have following neighbors:
      | planet |
      | Rion   |
      | Zerm   |

  Scenario:
    When "Formos" is first selected planet
    Then current planet should have following neighbors:
      | planet |
      | Rion   |

  Scenario:
    When "Rion" is first selected planet
    Then current planet should have following neighbors:
      | planet |
      | Kessel |