<!-- Modal -->
<div id="myModal<?php echo $row['student_id']?>" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change Profile Picture</h4>
                    </div>
                    <form action="controller/update_student_picture.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                    <input type="hidden" name="student_id" value="<?php echo $row['student_id']?>"/>
                    <img class="img-thumbnail img-responsive" width="150px" src="student_image/<?php echo $row['file']; ?>">
                    
                     <input type="file"  name="file" class="form-control">
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update" class="btn btn-primary btn-sm">Save changes</button>
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                    </div>
                </div>
                </div>