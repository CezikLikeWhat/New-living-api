Feature: I want to test profile data
  Background:
    Given I have a feature in system:
      | feature_id                           | name                                 | code_name                 | display_type           |
      | 4d5af1d8-fe64-4868-9377-4ed325da88bb | Turn off                             | TURN_OFF                  | toggle                 |
      | 4c6c73f8-b985-475a-a3be-f4e3fbf8529f | Turn on                              | TURN_ON                   | toggle                 |
      | 860fef44-84ea-4071-8c2a-942666f097b5 | Change the color of the light bulb   | CHANGE_COLOR_LIGHT_BULB   | toggle_and_colorpicker |
      | 99b7991d-cfc6-494b-a836-c401b18970c2 | Enable ambient mode on LED ring      | AMBIENT                   | toggle                 |
      | 35ef3bb5-51a9-4b9b-bfc7-6afca9001759 | Enable eye effect on LED ring        | EYE                       | toggle_and_colorpicker |
      | 99b7911d-cfc5-424b-a536-c401b18970c1 | Enable loading effect on LED ring    | LOADING                   | toggle_and_colorpicker |
      | c76b779d-ccdb-41be-97d6-8ce857886880 | Change motion detection distance(cm) | CHANGE_DETECTION_DISTANCE | input                  |
    And Today is "2023-01-01"
    And I have a devices features in system:
      | id                                   | feature_id                           | device_id                            | payload                                                                                                                                                                                                                                                                             |
      | cb9e8557-e415-45a6-8c10-6ebebe067038 | 99b7991d-cfc6-494b-a836-c401b18970c2 | 36340076-0431-4a95-8444-69cf1f3173ec | {"device":{"mac":"e4:5f:01:2b:58:01","type":"Led ring","id":"36340076-0431-4a95-8444-69cf1f3173ec"},"actual_status":{"TURN_ON":true,"TURN_OFF":false,"features":{"AMBIENT":{"status":false},"EYE":{"status":false,"color":"#000000"},"LOADING":{"status":true,"color":"#81ccdf"}}}} |
      | cb9e8557-e415-45a6-8c10-6ebebe067039 | 99b7911d-cfc5-424b-a536-c401b18970c1 | 36340076-0431-4a95-8444-69cf1f3173ec | {"device":{"mac":"e4:5f:01:2b:58:01","type":"Led ring","id":"36340076-0431-4a95-8444-69cf1f3173ec"},"actual_status":{"TURN_ON":true,"TURN_OFF":false,"features":{"AMBIENT":{"status":false},"EYE":{"status":false,"color":"#000000"},"LOADING":{"status":true,"color":"#81ccdf"}}}} |
      | 899bc67c-7166-4c9c-9c2f-57406373096d | 4d5af1d8-fe64-4868-9377-4ed325da88bb | 36340076-0431-4a95-8444-69cf1f3173ec | {"device":{"mac":"e4:5f:01:2b:58:01","type":"Led ring","id":"36340076-0431-4a95-8444-69cf1f3173ec"},"actual_status":{"TURN_ON":true,"TURN_OFF":false,"features":{"AMBIENT":{"status":false},"EYE":{"status":false,"color":"#000000"},"LOADING":{"status":true,"color":"#81ccdf"}}}} |
      | 902e8108-cf54-4ab0-9d05-e174c8060cf4 | 4c6c73f8-b985-475a-a3be-f4e3fbf8529f | 36340076-0431-4a95-8444-69cf1f3173ec | {"device":{"mac":"e4:5f:01:2b:58:01","type":"Led ring","id":"36340076-0431-4a95-8444-69cf1f3173ec"},"actual_status":{"TURN_ON":true,"TURN_OFF":false,"features":{"AMBIENT":{"status":false},"EYE":{"status":false,"color":"#000000"},"LOADING":{"status":true,"color":"#81ccdf"}}}} |
      | cb9e8557-e415-45a6-8c10-6ebebe067037 | 35ef3bb5-51a9-4b9b-bfc7-6afca9001759 | 36340076-0431-4a95-8444-69cf1f3173ec | {"device":{"mac":"e4:5f:01:2b:58:01","type":"Led ring","id":"36340076-0431-4a95-8444-69cf1f3173ec"},"actual_status":{"TURN_ON":true,"TURN_OFF":false,"features":{"AMBIENT":{"status":false},"EYE":{"status":false,"color":"#000000"},"LOADING":{"status":true,"color":"#81ccdf"}}}} |
      | f74053a6-4f1a-4cef-b37c-1b6eb26d76ec | 4d5af1d8-fe64-4868-9377-4ed325da88bb | 0ca28ec2-e9eb-4013-a121-097c380c55bd | {"device":{"mac":"00:00:00:00:00:00","type":"Light bulb","id":"0ca28ec2-e9eb-4013-a121-097c380c55bd"},"actual_status":{"TURN_ON":false,"TURN_OFF":true,"features":{"CHANGE_COLOR_LIGHT_BULB":{"status":false,"color":"#000000"}}}}                                                  |
      | abfc2d09-3b51-4c34-beee-541e375b86d8 | 4c6c73f8-b985-475a-a3be-f4e3fbf8529f | 0ca28ec2-e9eb-4013-a121-097c380c55bd | {"device":{"mac":"00:00:00:00:00:00","type":"Light bulb","id":"0ca28ec2-e9eb-4013-a121-097c380c55bd"},"actual_status":{"TURN_ON":false,"TURN_OFF":true,"features":{"CHANGE_COLOR_LIGHT_BULB":{"status":false,"color":"#000000"}}}}                                                  |
      | c3903be0-d7c6-4e8f-b959-93bb1e4f7aa6 | 860fef44-84ea-4071-8c2a-942666f097b5 | 0ca28ec2-e9eb-4013-a121-097c380c55bd | {"device":{"mac":"00:00:00:00:00:00","type":"Light bulb","id":"0ca28ec2-e9eb-4013-a121-097c380c55bd"},"actual_status":{"TURN_ON":false,"TURN_OFF":true,"features":{"CHANGE_COLOR_LIGHT_BULB":{"status":false,"color":"#000000"}}}}                                                  |
      | b332f520-d2e8-4741-9139-e718f934fcea | 4d5af1d8-fe64-4868-9377-4ed325da88bb | 6e2aae94-41fc-4765-b007-46f1994d0beb | {"device":{"mac":"22:22:22:22:22:22","type":"Distance sensor","id":"6e2aae94-41fc-4765-b007-46f1994d0beb"},"actual_status":{"TURN_ON":false,"TURN_OFF":true,"features":{"CHANGE_DETECTION_DISTANCE":{"status":false,"value":25}}}}                                                  |
      | d1723660-bedb-4ed9-a7da-cc5da0823931 | 4c6c73f8-b985-475a-a3be-f4e3fbf8529f | 6e2aae94-41fc-4765-b007-46f1994d0beb | {"device":{"mac":"22:22:22:22:22:22","type":"Distance sensor","id":"6e2aae94-41fc-4765-b007-46f1994d0beb"},"actual_status":{"TURN_ON":false,"TURN_OFF":true,"features":{"CHANGE_DETECTION_DISTANCE":{"status":false,"value":25}}}}                                                  |
      | 84a0879d-1378-46b0-9996-512f0b4f9a4a | c76b779d-ccdb-41be-97d6-8ce857886880 | 6e2aae94-41fc-4765-b007-46f1994d0beb | {"device":{"mac":"22:22:22:22:22:22","type":"Distance sensor","id":"6e2aae94-41fc-4765-b007-46f1994d0beb"},"actual_status":{"TURN_ON":false,"TURN_OFF":true,"features":{"CHANGE_DETECTION_DISTANCE":{"status":false,"value":25}}}}                                                  |
    And I have a devices in system:
      | id                                   | name                     | device_type     | mac_address       | user_id                              | created_at |
      | 0ca28ec2-e9eb-4013-a121-097c380c55bd | Light bulb - living room | Light bulb      | 00:00:00:00:00:00 | 92e1b2c3-2c18-4698-a764-6d1a42f650f5 | 2023-01-04 |
      | 6e2aae94-41fc-4765-b007-46f1994d0beb | Distance sensor - patio  | Distance sensor | 22:22:22:22:22:22 | 92e1b2c3-2c18-4698-a764-6d1a42f650f5 | 2023-01-04 |
      | 36340076-0431-4a95-8444-69cf1f3173ec | Led ring - tv            | Led ring        | e4:5f:01:2b:58:01 | 92e1b2c3-2c18-4698-a764-6d1a42f650f5 | 2023-01-04 |
    And I have user in system


  Scenario: I want to get Profile data
    When I send "GET" request to "/json/profile/get/92e1b2c3-2c18-4698-a764-6d1a42f650f5"
    Then response payload should be json:
    """
    {
      "user": {
        "first_name": "Andrzej",
        "last_name": "Chodnikowski",
        "email": "andrzej.chodnikowski@gmail.com"
      },
      "userDevices": [
        {
          "id": "0ca28ec2-e9eb-4013-a121-097c380c55bd",
          "name": "Light bulb - living room",
          "device_type": "LIGHT_BULB",
          "mac_address": "00:00:00:00:00:00",
          "created_at": "01-01-2023"
        },
        {
          "id": "6e2aae94-41fc-4765-b007-46f1994d0beb",
          "name": "Distance sensor - patio",
          "device_type": "DISTANCE_SENSOR",
          "mac_address": "22:22:22:22:22:22",
          "created_at": "01-01-2023"
        },
        {
          "id": "36340076-0431-4a95-8444-69cf1f3173ec",
          "name": "Led ring - tv",
          "device_type": "LED_RING",
          "mac_address": "e4:5f:01:2b:58:01",
          "created_at": "01-01-2023"
        }
      ]
    }
    """
    And response status code should be 200
