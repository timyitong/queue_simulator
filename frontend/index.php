<!DOCTYPE HTML>
<html>
  <head>
    <style>
      body {
        margin: 0px;
        padding: 0px;
      }
    </style>
  </head>

  <body>
    <div id="container"></div>
    <script src="http://d3lp1msu2r81bx.cloudfront.net/kjs/js/lib/kinetic-v4.5.4.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

    <script defer="defer">
    // Returns a random number between min and max

      function getRandom(min, max) {
        return Math.random() * (max - min) + min;
      }

    //global variables
      var stageHeight = 600,
          stageWidth = 600,
          company_num = 4,
          student_num = 4,
          resting_area_width = 100,
          resting_area_height = 50,
          company_area_width = 50,
          company_area_height = 50,
          i=0,
          j=0;


      var students = Array();
      var companies = Array();


      var data = {"json_data": 
        [{"cid": 0, "type": "enqueue", "time": 1, "sid": 0}, 
        {"cid": 0, "type": "enqueue", "time": 1, "sid": 1}, 
        {"cid": 1, "type": "enqueue", "time": 1, "sid": 2}, 
        {"cid": 1, "type": "enqueue", "time": 1, "sid": 3}, 
        {"cid": 0, "type": "dequeue", "time": 2, "sid": 0}, 
        {"cid": 1, "type": "dequeue", "time": 2, "sid": 2}, 
        {"cid": 1, "type": "dequeue", "time": 3, "sid": 3}, 
        {"cid": 2, "type": "enqueue", "time": 3, "sid": 0}, 
        {"cid": 0, "type": "enqueue", "time": 3, "sid": 2}, 
        {"cid": 0, "type": "dequeue", "time": 4, "sid": 1}, 
        {"cid": 2, "type": "dequeue", "time": 4, "sid": 0}, 
        {"cid": 0, "type": "enqueue", "time": 4, "sid": 3}, 
        {"cid": 1, "type": "enqueue", "time": 5, "sid": 1}, 
        {"cid": 1, "type": "enqueue", "time": 5, "sid": 0}, 
        {"cid": 0, "type": "dequeue", "time": 6, "sid": 2}, 
        {"cid": 1, "type": "dequeue", "time": 6, "sid": 1}, 
        {"cid": 1, "type": "dequeue", "time": 7, "sid": 0}, 
        {"cid": 2, "type": "enqueue", "time": 7, "sid": 2}, 
        {"cid": 2, "type": "enqueue", "time": 7, "sid": 1}, 
        {"cid": 0, "type": "dequeue", "time": 8, "sid": 3}, 
        {"cid": 2, "type": "dequeue", "time": 8, "sid": 2}, 
        {"cid": 2, "type": "enqueue", "time": 9, "sid": 3}, 
        {"cid": 2, "type": "dequeue", "time": 10, "sid": 1}, 
        {"cid": 2, "type": "dequeue", "time": 12, "sid": 3}]
};
      


      //stage
      var stage = new Kinetic.Stage({
        container: 'container',
        width: stageHeight,
        height: stageWidth
      });

      //layers
      var layer_top = new Kinetic.Layer();
      var layer_down = new Kinetic.Layer();

      //down layer 
      var resting_area = new Kinetic.Rect({
        x: stageWidth/2 - resting_area_width/2,
        y: stageHeight - resting_area_height-4,
        width: resting_area_width,
        height: resting_area_height,
        fill: 'white',
        stroke: 'red',
        strokeWidth: 4
      });

      var resting_area_position = {'x':stageWidth/2 - resting_area_width/2 , 'y': stageHeight - resting_area_height-4 };



      var companies_position = Array();

      for( i=0; i < company_num ; i++){

        var position = 20 + i*stageWidth/company_num;

        companies[i] = new Kinetic.Rect({
        x: position,
        y: 0.1 * stageHeight,
        width: company_area_width,
        height: company_area_height,
        fill: 'white',
        stroke: 'green',
        strokeWidth: 2
      });

        companies_position[i] = { 'x' : position , 'y': 0.1 * stageHeight };

      }



      layer_down.add(resting_area);

      for( i=0; i < company_num ; i++){
        layer_top.add(companies[i]);
      }

      // add the layer to the stage
      stage.add(layer_down);



      //top layer

      for( i=0; i < student_num ; i++){

          students[i] = new Kinetic.Circle({
            x: stage.getWidth() / 2 + getRandom(-resting_area_width/2, resting_area_width/2),
            y: stage.getHeight() - getRandom(0,resting_area_height),
            radius: 3,
            fill: 'blue',
            stroke: 'black',
            strokeWidth: 0.5
          });

      }

      // add the shape to the layer
      for( i=0; i < student_num ; i++){
        layer_top.add(students[i]);
      }

      stage.add(layer_top);



      //data processing
      var json = data.json_data;

        // [{"cid": 0, "type": "enqueue", "time": 1, "sid": 0}, 
        // {"cid": 0, "type": "enqueue", "time": 1, "sid": 1}, 
        // {"cid": 1, "type": "enqueue", "time": 1, "sid": 2}, 
        // {"cid": 1, "type": "enqueue", "time": 1, "sid": 3}, 

      var count = 0,
        mytime = 1,
        student_movement = Array(),
        j=0;


        var lastX = Array(),
            lastY = Array(),
            increX = Array(),
            increY = Array();


      //the initial random XY
      for(i=0; i<student_num; i++){
        lastX[i] = students[i].getX();
      }
           for(i=0; i<student_num; i++){
        lastY[i] = students[i].getY();
      }

      // initialize incre
      for(i=0; i<student_num; i++){
        increX[i] = 0;
      }     
      for(i=0; i<student_num; i++){
        increY[i] = 0;
      }
      //animation

      for(i=0; i<student_num; i++){
        //movement destination for this student
        student_movement[i] = { 'x': students[i].getX() , 'y': students[i].getY() }; 

      }

      var interval_constant = 200 ;
      
      var anim = new Kinetic.Animation( function(frame) {

        count++;
        // 50 count equals about 1 second
        //count always in 0 to 200(interval)

        //j was initialized as 0 and increase to infinity

        if( count ===  interval_constant ){
          //update movement info
          console.log("inside decision");

            //record last movement
            for( i=0 ; i<student_movement.length ; i++ ){
              lastX[i] = student_movement[i].x;
              lastY[i] = student_movement[i].y;
            }

            console.log( "lastX[0]  "+lastX[0]+"    lastY[0]  "+lastY[0] );


          while( json[j].time <= mytime ){
            //for one time period and one student here
            console.log( "jsonTime "+json[j].time + "  mytime: "+ mytime+ "   j="+ j );

            var id = json[j].sid,
                cid = json[j].cid,
                type = json[j].type,
                destination = resting_area_position; // by default the student goes to resting area

                if( type == "enqueue" ){
                  console.log("one student enqueue");
                  destination = companies_position[cid];
                }


            // update  new destination into movement Array
            student_movement[ id ] = destination;

            j++;

          }

          //console.log("before determine incre:  sm[0]: "+ student_movement[0]+ "  lastX[0]: "+lastX[0]);

          for( i=0 ; i<student_movement.length ; i++ ){
            //calculate the increX and increY
            increX[i] = ( student_movement[i].x - lastX[i] ) / interval_constant;
            increY[i] = ( student_movement[i].y - lastY[i] ) / interval_constant;
          }

          console.log( "mytime = "+ mytime );
          mytime++;



          //update count to zero
          count = 0 ;
        }



            console.log( "before movement ---- increX[0]  "+increX[0]+"    increY[0]  "+increY[0] );
        //do the movements 
        for( i=0 ; i< students.length; i++){
          students[i].setX( lastX[i] + increX[i]*count );
          students[i].setY( lastY[i] + increY[i]*count );
        }


    // update stuff
  }, layer_top);

  anim.start();



    </script>
  </body>

</html>