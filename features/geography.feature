Feature: Check geographical models behaviours

  Scenario: Checking planet's id generator
    Given there's a planet named "Coruscant"
    Then its id should be "coruscant"
    And its neighbour list should not have any planets

  Scenario: Checking planet's id generator for more complicated names
    Given there's a planet named "Berrol's Donn"
    Then its id should be "berrols-donn"
    And its neighbour list should not have any planets

  Scenario: Checking if planets are connecting in proper way
    Given there's a planet named "Corellia" with "Coruscant" neighbor
    Then its id should be "corellia"
    And its neighbour list should have "1" planet

  Scenario: Checking route empty aggregation
    Given there's a route named "Kessel Run" with following planets:
      | name |
    Then its planets list should not have any planets

  Scenario: Checking route aggregation
    Given there's a route named "Kessel Run" with following planets:
      | name   |
      | Formos |
      | Rion   |
      | Kessel |
    Then its planets list should have "3" planets
    And all of its planets should not be connected as neighbors