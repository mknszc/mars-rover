
## Mars Rover

A squad of robotic rovers are to be landed by NASA on a plateau on Mars. This plateau, which is
curiously rectangular, must be navigated by the rovers so that their on board cameras can get a
complete view of the surrounding terrain to send back to Earth.
A rover's position and location is represented by a combination of x and y co-ordinates and a letter
representing one of the four cardinal compass points. The plateau is divided up into a grid to
simplify navigation. An example position might be 0, 0, N, which means the rover is in the bottom
left corner and facing North.
In order to control a rover, NASA sends a simple string of letters. The possible letters are 'L', 'R' and
'M'. 'L' and 'R' makes the rover spin 90 degrees left or right respectively, without moving from its
current spot. 'M' means move forward one grid point, and maintain the same heading.
Assume that the square directly North from (x, y) is (x, y+1).
Create a Web API to create and manage rovers. Resources must be created and managed via
RESTful endpoints.

## Requirements
Laravel 9.7.0

Php 8.0.2

##User guide

1- Create plateau
    
    - Request
    
        - curl --location --request POST 'http://domain/api/createPlateau' \
          --form 'name="mars1"' \
          --form 'cord_x="9"' \
          --form 'cord_y="9"'
      
    - Response
        
        - {"message":"Plateau Created","name":"mars1","coordinate":{"cord_x":"9","cord_y":"9"}}
        
        - {"message":"Plateau Here","name":"mars1","coordinate":{"cord_x":"9","cord_y":"9"}}

2- Get plateau
    
    - Request
    
        - curl --location --request POST 'http://domain/api/getPlateau' \
          --form 'name="mars1"'
    
    - Response
     
        -{"message":"Plateau Here","name":"mars1","coordinate":{"cord_x":"9","cord_y":"9"}}
        
3- Create rover
    
    - Request
        
        - curl --location --request POST 'http://domain/api/crateRover' \
          --form 'name="rover4"' \
          --form 'plateau_name="mars1"' \
          --form 'start_cord_x="0"' \
          --form 'start_cord_y="0"' \
          --form 'direction="W"'
    
    - Response
        
        - {"message":"Rover Created","name":"rover4","info":{"cord_x":"0","cord_y":"0","direction":"W","plateau_name":"mars1"}}
        - {"message":"Rover Here","name":"rover4","info":{"cord_x":"0","cord_y":"0","direction":"W","plateau_name":"mars1"}}

4- Send commands to rover
    
    - Request
        
        - curl --location --request POST 'http://domain/api/sendCommandRover' \
          --form 'name="rover1"' \
          --form 'commands="LM"'
          
    - Response
        
        - {"message":"Rover state change"}
        
5- Get rover

    - Request
        
        - curl --location --request POST 'http://domain/api/getRover' \
          --form 'name="rover1"'
    
    - Response
        
        - "message":"Rover Here","name":"rover1","info":{"cord_x":1,"cord_y":0,"direction":"W","plateau_name":"mars1"}}
        
6- Get rover state

    - Request 
        
        - curl --location --request POST 'http://domain/api/getRoverState' \
          --form 'name="rover1"'
    
    - Response
    
        - {"message":"Rover Here","name":"rover1","info":{"cord_x":1,"cord_y":0,"direction":"W","plateau_name":"mars1"}}


## License

The Project [MIT license](https://opensource.org/licenses/MIT).
