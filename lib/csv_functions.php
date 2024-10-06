<?php 
    //function for reading awards csv file
    function read_csv_awards($file_path){
        //open file for reading
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(!feof($file)) {
                $content =fgets($file);
                if(strlen($content)<5) continue;
                $section=explode(',',$content);
                //write html to page
                '<br>';
                echo "<div class=\"col-lg-4\">
                        <div class=\"card mt-4 border-0 shadow\">
                            <div class=\"card-body p-4\">
                                <h4 class=\"font-size-22 my-4\"><a href=\"javascript: void(0);\">$section[0]</a></h4>
                                <p class=\"text-muted\">$section[1]</p>
                            </div><!-- end cardbody -->
                        </div><!-- end card -->
                    </div><!-- end col -->";
            }
        }
        else{
            echo 'File not found.';
        }
        //close file
        fclose($file);
    }

    //function for reading team csv file
    function read_csv_team($file_path){
        //iterator for team member images
        $i = 1;
        //open file
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(!feof($file)) {
                $content =fgets($file);
                if(strlen($content)<5) continue;
                $section=explode(',',$content);
                //write html to page
                '<br>';
                echo "<div class=\"col-lg-3 col-sm-6\">
                        <div class=\"team-box mt-4 position-relative overflow-hidden rounded text-center shadow\">
                            <div class=\"position-relative overflow-hidden\">
                                <img src=\"images/team/img_$i.jpg\" alt=\"\" class=\"img-fluid d-block mx-auto\" />
                                <ul class=\"list-inline p-3 mb-0 team-social-item\">
                                <p style=\"color: white\">$section[2]</p>
                                </ul>
                            </div>
                            <div class=\"p-4\">
                                <h5 class=\"font-size-19 mb-1\">$section[0]</h5>
                                <p class=\"text-muted text-uppercase font-size-14 mb-0\">$section[1]</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->";
                 $i++;   
            }
        }
        else{
            echo 'File not found.';
        }
        //close file
        fclose($file);
    }