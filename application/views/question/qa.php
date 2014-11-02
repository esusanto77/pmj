<?php $this->load->view("template/header");?>

  <script src="<?php echo base_url("public")?>/assets/js/jtransit.js"></script>
      <div class="site-main" id="main">
        <div class="container">
          <div class="row">
            <section class="qa-section">
              <header class="qa-section-header clearfix">
                <h2 class="qa-section-title col-md-4"><?php echo $categoryLabel?></h2>
                <div class="qa-section-progress col-md-8">
                  <span><?php echo floor($percent)?>%</span>
                  <div class="progress-bar">
                    <div style="width:0%"></div>
                  </div>
                </div>
              </header>
              <!-- end of .qa-section-header -->
               <?php $nextCategory = $qacategory+1; ?>

              <div class="qa-question-list-wrapper">
                <form method="post" action="<?php echo base_url()?>question?q=<?php  if($nextCategory > 4){ echo "done"; } else {echo $nextCategory;} ?>" class='form-qa'>
                  <div class="qa-question-list clearfix">

                  <?php foreach ($question["questions"] as $key => $q):?>
                    <div class="qa-question-item">
                      <div class="qa-sub-question">
                        <span class="qa-question-subtitle">Question</span>
                        <h3 class="qa-question-title" id="<?php echo $q["question_id"]?>"><?php echo $q["question_title"]?></h3>

                        <?php if($q["type"] == "country"):?>
                            <div class="qa-choice clearfix">
                              <!--<input type="text" id="value-country">-->
                               <select class="country form-country" style="width:300px;" name="<?php echo $q["question_id"];?>">
                                  <option></option>
                                  <?php foreach($q["choices"] as $c): ?>
                                    <option value="<?php echo $c["value"]?>"><?php echo $c["label"]?></option>                                                                        
                                  <?php endforeach; ?>                                                                
                                </select>                                                          
                              </div>
                        <?php endif; ?>

                        <?php if($q["type"] == "choices"):?>
                          <div class="qa-choice clearfix">
                            <?php foreach($q["choices"] as $c):?>

                              <label class="clearfix" style="margin-bottom:30px;" id="<?php echo $c["value"]?>">

                                <input class="form-choice" type="radio" name="<?php echo $q["question_id"];?>" value="<?php echo $c["value"]?>">
                                <?php if($c["label"]!=""){ ?>
                                <span><?php echo $c["label"]?></span>
                                <?php }else{ ?>
                                 <span style=" color: transparent;">NONE</span>
                                 <?php } ?>
                              </label>
                            <?php endforeach; ?>                            
                          </div>
                        <?php endif; ?>

                        <?php if($q["type"] == "checkbox"):?>
                          <div class="qa-choice clearfix">
                            <div class="row">

                              <?php foreach($q["checkbox"] as $inc => $c):?>
                                <label class="clearfix col-xs-5" style="text-align:left;margin-bottom:10px;" id="<?php echo $c["value"]?>">
                                  <input class="form-checkbox" type="checkbox" name="check_<?php echo $q["question_id"];?>[]" value="<?php echo $c["value"]?>">
                                  <?php if($c["label"]!=""){ ?>
                                  <span style="display:inline;"><?php echo $c["label"]?></span>
                                  <?php }else{ ?>
                                   <span style=" color: transparent;">NONE</span>
                                   <?php } ?>
                                </label>
                              <?php endforeach; ?>  
                               

                            </div>                       
                          </div>
                        <?php endif; ?>

                         <?php if($q["type"] == "birthday"):?>
                          <div class="qa-choice clearfix">
                            <input class="form-control form-datepicker datepicker" type="input" name="<?php echo $q["question_id"];?>" value="" data-date-format="yyyy-mm-dd" data-date-viewmode="years" placeholder="yyyy-mm-dd">
                          </div>
                        <?php endif; ?>

                         <?php if($q["type"] == "text"):?>
                          <div class="qa-choice clearfix">                          
                            <textarea class="form-control form-text" name="<?php echo $q["question_id"];?>" rows="10"></textarea>
                          </div>
                        <?php endif; ?>

                        <?php if($q["type"] == "datepicker"):?>
                          <div class="qa-choice clearfix">
                          <input class="form-control form-datepicker datepicker" type="text" name="<?php echo $q["question_id"];?>" value="" data-date-format="yyyy-mm-dd" data-date-viewmode="years" placeholder="Enter Your Birth of Date">                            
                          </div>
                        <?php endif; ?>

                        <?php if($q["type"] == "3text"):?>
                          <div class="qa-choice clearfix">
                            <input class="form-control form-1value" type="text" placeholder="First description"><br>
                            <input class="form-control form-2value" type="text" placeholder="Second description"><br>
                            <input class="form-control form-3value" type="text" placeholder="Third description"><br>
                            <input class="form-control form-3text" type="hidden" name="<?php echo $q["question_id"];?>" value="">
                          </div>
                        <?php endif; ?>



                      </div>
                      
                     
                      <?php if(!empty($q["related"])):?>
                      <?php foreach ($q['related'] as $i => $r):?>
                       <div class="qa-sub-question">
                        <span class="qa-question-subtitle">Question</span>
                        <h3 class="qa-question-title" id="<?php echo $q["question_id"]?>"><?php echo $q['related'][$i]["question_title"]?></h3>


                      <?php if($r["type"] == "list"):?>
                        <div class="qa-choice clearfix">                               
                          <input type="hidden" class="form-list" name="<?php echo $r["question_id"];?>" id="listContainer-<?php echo $r["question_id"];?>">
                            <select class="ddslick">
                              <?php foreach($r["choices"] as $c):?>
                                <option value="<?php echo $r["question_id"];?>_<?php echo $c["value"]?>"><?php echo $c["label"]?></option>                                                                        
                              <?php endforeach; ?>                                                                
                            </select>                                                          
                          </div>
                      <?php endif; ?>



                        <?php if($r["type"] == "choices"):?>
                          <div class="qa-choice clearfix">
                            <?php foreach($r["choices"] as $c):?>
                              <label class="clearfix" style="margin-bottom:30px;" id="<?php echo $c["value"]?>">
                                <input class="form-choice" type="radio" name="<?php echo $r["question_id"];?>" value="<?php echo $c["value"]?>">
                                <?php if($c["label"]!=""){ ?>
                                <span><?php echo $c["label"]?></span>
                                <?php }else{ ?>
                                 <span style=" color: transparent;">NONE</span>
                                 <?php } ?>
                              </label>
                            <?php endforeach; ?>                            
                          </div>
                        <?php endif; ?>

                        <?php if($r["type"] == "ethnic"):?>
                          <div class="qa-choice clearfix">
                            <?php foreach($r["choices"] as $c): ?>
                              <label class="clearfix ethnic-choice ethnic-<?php echo $c['parent']; ?>" style="margin-bottom:30px;" id="<?php echo $c["value"]?>">
                                <input class="form-choice" type="radio" name="<?php echo $r["question_id"];?>" value="<?php echo $c["value"]?>">
                                <?php if($c["label"]!=""){ ?>
                                <span><?php echo $c["label"]?></span>
                                <?php }else{ ?>
                                 <span style=" color: transparent;">NONE</span>
                                 <?php } ?>
                              </label>
                            <?php endforeach; ?>                            
                          </div>
                        <?php endif; ?>



                        <?php if($r["type"] == "checkbox"):?>
                          <div class="qa-choice clearfix">
                            <div class="row">
                            <?php foreach($r["choices"] as $inc => $c):?>
                              <label class="clearfix col-xs-5" style="text-align:left;margin-bottom:10px;" id="<?php echo $c["value"]?>">
                                <input class="form-checkbox" type="checkbox" name="check_<?php echo $r["question_id"];?>[]" value="<?php echo $c["value"]?>">
                                <?php if($c["label"]!=""){ ?>
                                <span style="display:inline;"><?php echo $c["label"]?></span>
                                <?php }else{ ?>
                                 <span style=" color: transparent;">NONE</span>
                                 <?php } ?>
                              </label>
                            <?php endforeach; ?>
                            </div>
                          </div>
                        <?php endif; ?>

                         <?php if($r["type"] == "text"):?>
                          <div class="qa-choice clearfix">                          
                            <input class="form-control form-text" type="input" name="<?php echo $r["question_id"];?>" value="" class="form-control">                           
                          </div>
                        <?php endif; ?>

                        <?php if($r["type"] == "datepicker"):?>
                          <div class="qa-choice clearfix">
                            <input class="form-control form-datepicker datepicker" type="input" name="<?php echo $r["question_id"];?>"value="" data-date-format="yyyy-mm-dd" data-date-viewmode="years" placeholder="Enter Your Birth of Date">
                          </div>
                        <?php endif; ?>

                        <?php if($r["type"] == "3text"):?>
                          <div class="qa-choice clearfix">
                            <input class="form-control form-1value" type="text" placeholder="First description"><br>
                            <input class="form-control form-2value" type="text" placeholder="Second description"><br>
                            <input class="form-control form-3value" type="text" placeholder="Third description"><br>
                            <input class="form-control form-3text" type="hidden" name="<?php echo $r["question_id"];?>" value="">
                          </div>
                        <?php endif; ?>

                      </div>
                       <?php endforeach; ?>     
                      <?php endif; ?>
                    </div>

                  <?php endforeach; ?>                                             
                  <!-- end of .qa-question-item -->
                    
                  </div>
                  
                  <!-- end of .qa-question-list -->
                  <input type="hidden" name="progress" id="currentProgress" value="">
                  <input type="hidden" name='qa-category' id="currentCategory" value="<?php echo $qacategory?>"> 

                </form>
                <input type="hidden" name="counter" id="currentCounter" value="<?php echo floor($percent)?>">
              </div>
              <!-- end of .qa-question-list-wrapper -->
              
              <nav class="qa-section-nav">

                <a class="prev btn btn-primary disabled" href="#">Back</a>
                <input type='submit' class="next btn btn-primary disabled" value="next" name='submit'>
                
              </nav>

              <!-- end of .qa-section-nav -->
            </section>
            
            <!-- end of .qa-section -->
          </div>
        </div>
      </div>
<?php $this->load->view("template/footer");?>