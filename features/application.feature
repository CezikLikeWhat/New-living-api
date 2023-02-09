Feature: I want to test application data
  Scenario: I want to get application information
  When I send "GET" request to "/json/application"
  Then response payload should be json:
  """
  {
    "name": "New Living - API",
    "version": "1.0.0",
    "licence": "MIT",
    "about": "New Living is an open source application that allows users to easily add, remove and manage Smart House devices. The user, using RaspberryPi devices and Docker containers, is able to build an entire Smart House ecosystem, and from the web application is able to manage various device parameters such as bulb color or light animations or many more. The application is open source and open to expansion by users. Anyone who creates a Smart House module can share it with documentation with the rest of the community."
  }
  """
  And response status code should be 200