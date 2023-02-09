Feature: I want to test author data
  Scenario: I want to get author information
  When I send "GET" request to "/json/author"
  Then response payload should be json:
  """
  {
    "name": "Cezary Maćkowski",
    "about": "My name is Cezary Maćkowski. I'm a final year student in the field of engineering computer science at the Nicolaus Copernicus University in Torun. I have been working as a Backend/Cloud Developer at Iteo since March 2022. I work with technologies such as PHP(Symfony), Twig, Docker and Google Cloud Platform. I'm interested in cyber security, hacking, IoT (Internet of Things) and web technologies in general. In my free time I create projects based on Go and Python programming languages.",
    "contact": {
      "github": "https://github.com/CezikLikeWhat",
      "email": "cezarymackowski99@gmail.com",
      "dockerhub": "https://hub.docker.com/u/cezarymackowski",
      "linkedin": "https://www.linkedin.com/in/cezary-ma%C4%87kowski-662194223/"
    }
  }
  """
  And response status code should be 200