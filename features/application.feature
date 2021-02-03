Feature: Check application behaviour

  Background:
    Given there's an atlas built from route array:
      | route                 | planets              |
      | Kessel Run            | Formos, Rion, Kessel |
      | Kessel Trade Corridor | Kessel, Zerm         |
    And given atlas is mounted in a navigator instance

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

  Scenario:
    When "Zerm" is first selected planet
    Then current planet should have following neighbors:
      | planet |
      | Kessel |
