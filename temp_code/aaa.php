<?php

$json_value = '[[0.515400,0.515400,0.612400,0.586300,0.544900,0.544900,0.612400,0.450700,0.467700,0.450700,0.599500,0.450700,0.544900,0.599500,0.649500,0.572800,0.572800,0.559000,0.500000,0.250000],[0.375000,0.484100,0.467700,0.500000,0.353600,0.450700,0.375000,0.433000,0.330700,0.433000,0.484100,0.395300,0.395300,0.572800,0.467700,0.375000,0.306200,0.515400,0.484100,0.250000],[0.353600,0.306200,0.216500,0.216500,0.353600,0.330700,0.353600,0.250000,0.279500,0.176800,0.467700,0.353600,0.375000,0.306200,0.176800,0.330700,0.250000,0.216500,0.176800,0.250000],[0.250000,0.279500,0.176800,0.216500,0.279500,0.279500,0.306200,0.216500,0.216500,0.176800,0.467700,0.306200,0.353600,0.279500,0.176800,0.176800,0.216500,0.176800,-1.000000,0.216500]]';

$json = '[[17,17,5,30,30,13,13,13,31,30,30,14,29,29,2,13,5,10,26,4],[3,19,19,5,21,30,26,7,9,14,27,21,1,2,13,19,15,5,10,11],[22,13,15,0,22,0,21,3,1,2,12,22,14,0,0,20,6,15,5,14],[7,23,17,3,27,3,8,31,12,15,22,17,0,5,3,9,8,13,-1,2]]';

$aa = json_decode($json, 1); //4*20的数组
$vv = json_decode($json_value, 1);
$a = array(); //20*4的数组
$v = array(); //20*4的数组

echo "\n----------------------------------------------------------------------------------------------------\n";
for ($i=0; $i<4; $i++) {

	for ($j = 0; $j < 20; $j++) {
		
		if ($aa[$i][$j] == -1) {
			
			printf("   | ");
		
		} else {
		
			printf("%2d | ", $aa[$i][$j]);
		}
	}
	echo "\n----------------------------------------------------------------------------------------------------\n";
}

//转成20*4的数组
for ($i=0; $i<20; $i++) {

	foreach ($aa as $key => $value) {
		
		$a[$i][] = $value[$i];
	}
	
	foreach ($vv as $key1 => $value1) {
		
		$v[$i][] = $value1[$i];
	}	
}


//用来装结果的数组
$r = array();

$flag = false;

//遍历
for ($i=0; $i<20; $i++) {

	//$tmp_1:  		当前优先
	//$tmp_2:  		下一位优先	
	//$tmp_0:  		当前单个		
	
	unset($tmp_0);
	unset($tmp_1);
	unset($tmp_2);
	
	for ($j = 0; $j < 3; $j++) {
	
		/*
		if ($i == 2 && $a[$i][$j] == 17) {
			
			$a[$i][$j] = -1;
			$v[$i][$j] = -1;
		}
		*/
	
		if ($a[$i][$j] != -1 && $i < 19 && ($key = array_search($a[$i][$j], $a[$i + 1])) !== false) {

			//if ($j > $key) {
			if ($v[$i][$j] < $v[$i+1][$key]) {
				
				//echo "(升)";
				//array_push($tmp, $a[$i][$j] . "(下一位优先)");
				
				if (!isset($tmp_2)) {
					
					$tmp_2 = $a[$i][$j];
					
					if ($i > 0 && $i < 17 && 
					array_search($tmp_2, $a[$i - 1]) !== false &&
					array_search($tmp_2, $a[$i + 1]) !== false &&
					array_search($tmp_2, $a[$i + 2]) !== false && 
					$r[$i] == $tmp_2) {
						
						unset($tmp_2);
					}
				}
			
			//} else if ($j < $key) {
			} else if ($v[$i][$j] > $v[$i+1][$key]) {
				
				//echo "(降)";
				//array_unshift($tmp, $a[$i][$j] . "(当前优先)");
				
				if (!isset($tmp_1)) {
					
					$tmp_1 = $a[$i][$j];
				}
			
			//} else if ($j == $key) {
			} else if ($v[$i][$j] == $v[$i+1][$key]) {
				
				if (!isset($tmp_2) && $r[$i] != $a[$i][$j]) {
									
					$tmp_2 = $a[$i][$j];
				}
				
				//echo "(平)";
				//array_unshift($tmp, $a[$i][$j] . "(看情况)");
				
				/*
				if (isset($tmp_1)) {
				
					$tmp_2 = $a[$i][$j];	
				
				} else {
					
					$tmp_1 = $a[$i][$j];
				}*/

				
				/*
				if ($v[$i][$j] <= $v[$i][$key]) {
					
					if (!isset($tmp_1))
						$tmp_1 = $a[$i][$j];
					
				} else {
					
					if (!isset($tmp_2))
						$tmp_2 = $a[$i][$j];
				}
				*/
				
			}
		
		} else if ($a[$i][$j] != -1) {
			
			//echo "(降)";
			//array_unshift($tmp, $a[$i][$j] . "(当前优先)");
			
			if (!isset($tmp_0) && $i > 0) {
			//if (!isset($tmp_0) && ) {
				
				if (array_search($a[$i][$j], $a[$i - 1]) === false && $j < 2) {
					
					$tmp_0 = $a[$i][$j];
					
				} else if (array_search($a[$i][$j], $a[$i - 1]) !== false && $r[$i-1] != $a[$i][$j] && $j < 2) {
					
					$tmp_0 = $a[$i][$j];
				}
			}
		}
	}
	
	if ($i == 14) {
		
		echo $tmp_1 . " : 1\n";
		echo $tmp_2 . " : 2\n";
		echo $tmp_0 . " : 0\n";
	}
	
	
	if (isset($tmp_1) && !isset($tmp_2) && isset($r[$i])) {
		
		$r[$i+1] = $tmp_1;
		unset($tmp_1);
	}	
	
	if (isset($tmp_1) && !isset($r[$i])) {
		
		$r[$i] = $tmp_1;
		unset($tmp_1);
	}
	
	if (isset($tmp_0) && !isset($r[$i])) {
		
		$r[$i] = $tmp_0;
		unset($tmp_0);
	}

	if (isset($tmp_2) && !isset($r[$i])) {
		
		$r[$i] = $tmp_2;
		unset($tmp_2);
	}
		
	if (!isset($r[$i])) {
		
		$r[$i] = $a[$i][0];
	}
	
	if (isset($tmp_2) && !isset($r[$i+1])) {
		
		$r[$i+1] = $tmp_2;
		unset($tmp_2);
	}

	/*
	if (isset($tmp[0]) && !isset($r[$i])) {
		
		$r[$i] = $tmp[0];
	}
	
	if (isset($tmp[1]) && !isset($r[$i+1])) {
			
		$r[$i+1] = $tmp[1];
	}
	
	if (!isset($r[$i])) {
			
		$r[$i] = 0;
	}
	
	echo $i . ":\n";
	print_r($tmp);
	*/
	
	
}


ksort($r);

print_r($r);

foreach ($r as $item) {
	
	printf("%02d-", $item);
}



/*

[17,17,25,17,29,29,29, 5, 5,31,29, 5, 0,27,13,28,12,29,29,16],
[-1,-1,19,25,17,30,30,29,15,15,31,29, 5, 0,28,15,-1,12,16,29],
[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,15,-1,-1],
[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1]



正确的:
25, 17, 29, 30, 29, 5, 15, 31, 29, 5, 0, 27, 13, 28, 15, 12, 29, 16,
算出来的：
25, 17, 29, 30, 30, 5, 15, 15, 15, 15, 15, 15, 28, 28, 28, 29, 16, 16




*/

exit;
?>

    #include <stdio.h>
    
    float data[32*20] = {0.0,0.0,0.0,0.0,0.0,0.433,0.7806,0.3536,0.1768,0.4507,0.3062,0.0,0.0,0.25,0.2165,0.0,0.2165,0.0,0.0,0.0,0.2165,0.0,0.0,0.0,0.0,0.433,0.4841,0.0,0.375,0.7395,0.8197,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.2165,0.0,0.0,0.0,0.0,0.375,0.0,0.0,0.696,0.8004,0.5303,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.25,0.3062,0.2795,0.4146,0.4146,0.2165,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.3307,0.0,0.3307,0.3307,0.125,0.0,0.1768,0.0,0.0,0.0,0.0,0.0,0.2165,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.3062,0.25,0.125,0.25,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.2165,0.0,0.0,0.0,0.0,0.0,0.5,0.7289,0.3062,0.2165,0.0,0.1768,0.25,0.1768,0.0,0.0,0.2795,0.0,0.7289,0.7395,0.1768,0.3307,0.0,0.0,0.0,0.0,0.25,0.0,0.0,0.0,0.0,0.5728,0.5863,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.25,0.2165,0.1768,0.0,0.2165,0.3307,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.2795,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.1768,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.125,0.0,0.0,0.1768,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.1768,0.0,0.0,0.0,0.0,0.0,0.6374,0.6614,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.625,0.5863,0.0,0.0,0.0,0.0,0.125,0.1768,0.0,0.0,0.1768,0.0,0.0,0.0,0.0,0.0,0.75,0.6847,0.0,0.0,0.0,0.2795,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.7603,0.7181,0.2165,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.6124,0.7706,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.7181,0.6731,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.2165,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.5,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.125,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.625,0.4146,0.5728,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.6374,0.6374,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.6731,0.5863,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.0,0.696,0.6847,0.7071,0.6614,0.0,0.0,0.0};
    
    int array_search(int num, int a[], int array_length) {
        
        if (array_length <= 0 || a == NULL) {
            return -2; // 数据异常
        }
        
        for (int i=0; i<array_length; i++) {
            
            if (num == a[i]) {
                return i;
            }
        }
        
        return -1; // 没找到
    }
    
    int isset(int num) {
        
        if (num != -1) {
            return 1;
        }else {
            return 0;
        }
    }
    
    void unset(int *num) {
        
        if (num != NULL) {
            *num = -1;
        }
    }
    
    int main(int argc, char *argv[]) {
        
        float dataa[20][32] = {0};
        
        for (int j=0; j<32; j++) {
            for (int i=0; i<20; i++) {
                dataa[i][j] = data[j*20 + i];
            }
        }
        
        int sortData[20][4];
        float sortValue[20][4];
        
        for (int i=0; i<4; i++) {
            for (int j=0; j<20; j++) {
                sortData[j][i] = -1;
                sortValue[j][i] = -1;
            }
        }
        
        for (int i=0; i<20; i++) {
            for (int k=0; k<4; k++) {
                
                int tmp = -1;
                float tmpData = 0;
                int aa = 0;
                
                for (int j=0; j<32; j++) {
                    
                    if (dataa[i][j] > tmpData && dataa[i][j] != 0) {
                        tmp = j;
                        tmpData = dataa[i][j];
                        aa = 1;
                    }
                }
                
                if	(aa == 1) {
                    
                    sortValue[i][k] = dataa[i][tmp];
                    dataa[i][tmp] = 0;
                    sortData[i][k] = tmp;
                    aa = 0;
                }
            }
        }
        
        
        int resultArray[20] = {-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1};
        
        printf("   ");
        for (int i=0; i<20; i++) {
            
            int tmp[3] = {-1,-1,-1};
            
            for (int j=0; j<3; j++) {
                
                int key = -1;
                
                if (sortData[i][j] != -1 && i<19 && (key = array_search(sortData[i][j], sortData[i+1], 4)) >= 0) {
                    
                    if (sortValue[i][j] < sortValue[i+1][key]) {
                        
                        if (!isset(tmp[2])) {
                            
                            tmp[2] = sortData[i][j];
                            
                            if (i > 0 && i < 17 &&
                                array_search(tmp[2], sortData[i - 1], 4) >= 0 &&
                                array_search(tmp[2], sortData[i + 1], 4) >= 0 &&
                                array_search(tmp[2], sortData[i + 2], 4) >= 0 &&
                                resultArray[i] == tmp[2]) {
                                
                                unset(&tmp[2]);
                            }
                        }
                        
                    }else if (sortValue[i][j] > sortValue[i+1][key]) {
                        
                        if (!isset(tmp[1])) {
                            
                            tmp[1] = sortData[i][j];
                        }
                        
                    }else if (sortValue[i][j] == sortValue[i+1][key]) {
                        
                        if (!isset(tmp[2]) && resultArray[i] != sortData[i][j]) {
                            
                            tmp[2] = sortData[i][j];
                        }
                    }
                    
                }else if (sortData[i][j] != -1) {
                    
                    if (!isset(tmp[0]) && i > 0) {
                        
                        if (array_search(sortData[i][j], sortData[i-1], 4) == -1 && j < 2) {
                            
                            tmp[0] = sortData[i][j];
                            
                        }else if (array_search(sortData[i][j], sortData[i-1], 4) >= 0 && resultArray[i-1] != sortData[i][j] && j < 2) {
                            
                            tmp[0] = sortData[i][j];
                        }
                    }
                }
            }
            
            if (isset(tmp[1]) && !isset(tmp[2]) && isset(resultArray[i])) {
                
                resultArray[i+1] = tmp[1];
                unset(&tmp[1]);
            }
            
            if (isset(tmp[1]) && !isset(resultArray[i])) {
                
                resultArray[i] = tmp[1];
                unset(&tmp[1]);
            }
            
            if (isset(tmp[0]) && !isset(resultArray[i])) {
                
                resultArray[i] = tmp[0];
                unset(&tmp[0]);
            }
            
            if (isset(tmp[2]) && !isset(resultArray[i])) {
                
                resultArray[i] = tmp[2];
                unset(&tmp[2]);
            }
			
            if (!isset(resultArray[i])) {
                
                resultArray[i] = sortData[i][0];
                
                if (resultArray[i] == -1) {
                    
                    resultArray[i] = 0;
                }
            }
            
            
            if (isset(tmp[2]) && !isset(resultArray[i+1])) {
                
                resultArray[i+1] = tmp[2];
                unset(&tmp[2]);
            }
            
            printf("%2d ", resultArray[i]);
        }
        
        printf("\n\n");
        
        // print
        /*
         for (int j=31; j>=0; j--) {
         
         printf("%2d: ",j);
         for (int i=0; i<20; i++) {
         printf("%.4f ", dataa[i][j]);
         }
         printf("\n");
         }
         */
        
        for (int i=0; i<4; i++) {
            
            printf("%d: ", i);
            for (int j=0; j<20; j++) {
                if (sortData[j][i] != -1) {
                    printf("%2d ", sortData[j][i]);
                }else {
                    printf("   ");
                }
            }
            printf("\n");
        }
        printf("\n");
        
        for (int i=0; i<4; i++) {
			
			printf("%d: ", i);
			for (int j=0; j<20; j++) {
				if (sortValue[j][i] != -1) {
					printf("%.4f  ", sortValue[j][i]);
				}else {
					printf("        ");
				}
			}
			printf("\n");
		}
		printf("\n");
    }
    
    /*
     17-19-29-22-16-00-00-06-18-02-01-15-07-27-31-17-31-26-26-06-
     17 19 29 22 16  0  0  6 18  2  1 15  7  6 31 17 31 26 26  6 
     17-19-29-22-16-00-00-06-18-02-01-15-07-27-31-17-31-26-26-06-
     
     0: 17 19 19 29 16 16  0  6 18  2  1 15 27 31 17 17 31 26  6  6 
     1:  1 17 29 22 12  0  6 18  2  1 15  7  7 27 31 31 26    26    
     2:  2  7       15  1  1  0  3  0  2  8  6  0  0 10  8     4    
     3:  6 20           2  4  3  1  3  0  6  8  6 16  8  6     2 
     
     
     17 19
     19 29
     29 22
     29 16
     16  0
     0  1
     0  6
     
     
     
     
     
     
     
     
     [[17,19,19,29,16,16,0, 6,18,2, 1,15,27,31,17,17,31,26,6,6],
     [  1,17,29,22,12, 0,6,18, 2,1,15, 7, 7,27,31,31,26,-1,26,-1],
     [  2, 7,-1,-1,15, 1,1, 0, 3,0, 2, 8, 6, 0, 0,10,8,-1,4,-1],
     [  6,20,-1,-1,-1, 2,4, 3, 1,3, 0, 6, 8, 6,16,8,6,-1,2,-1]]';
     
     
     
     0: 0.7500  0.7181  0.6731  0.5863  0.6250  0.5863  0.7806  0.7289  0.7706  0.8004  0.8197  0.6614  0.6374  0.6960  0.7603  0.7181  0.6614  0.4146  0.7289  0.7395  
     1: 0.2165  0.6847  0.6731  0.5000  0.1768  0.4330  0.5000  0.6124  0.6960  0.7395  0.6374  0.5728  0.5863  0.6374  0.6847  0.7071  0.6250          0.5728          
     2: 0.2165  0.3307                  0.1768  0.4330  0.4841  0.3536  0.4146  0.4507  0.5303  0.2500  0.2500  0.2500  0.2165  0.2795  0.3307          0.2165          
     3: 0.2165  0.2165                          0.3750  0.3307  0.2795  0.3750  0.4146  0.3062  0.1768  0.2165  0.1768  0.1768  0.2165  0.2795          0.1250  
     
     
     0: 0.7500  0.7181  0.6731  0.5863  0.6250  0.5863  0.7806  0.7289  0.7706  0.8004  0.8197  0.6614  0.6374  0.6960  0.7603  0.7181  0.6614  0.4146  0.7289  0.7395  
     1: 0.2165  0.6847  0.6731  0.5000  0.1768  0.4330  0.5000  0.6124  0.6960  0.7395  0.6374  0.5728  0.5863  0.6374  0.6847  0.7071  0.6250          0.5728          
     2: 0.2165  0.3307                  0.1768  0.4330  0.4841  0.3536  0.4146  0.4507  0.5303  0.2500  0.2500  0.2500  0.2165  0.2795  0.3307          0.2165          
     3: 0.2165  0.2165                          0.3750  0.3307  0.2795  0.3750  0.4146  0.3062  0.1768  0.2165  0.1768  0.1768  0.2165  0.2795          0.1250          
     
     
     
     
     
     
    */



/*
 
 0,0,0.0000]0,1,0.0000]0,2,0.0000]0,3,0.0000]0,4,0.0000]0,5,0.0000]0,6,0.0000]0,7,0.0000]0,8,0.0000]0,9,0.0000]0,10,0.0000]0,11,0.0000]0,12,0.5995]0,13,0.0000]0,14,0.0000]0,15,0.0000]0,16,0.0000]0,17,0.0000]0,18,0.0000]0,19,0.0000]1,0,0.0000]1,1,0.0000]1,2,0.0000]1,3,0.0000]1,4,0.0000]1,5,0.0000]1,6,0.0000]1,7,0.0000]1,8,0.9014]1,9,0.7603]1,10,0.0000]1,11,0.0000]1,12,0.7071]1,13,0.9100]1,14,0.6495]1,15,0.0000]1,16,0.0000]1,17,0.0000]1,18,0.0000]1,19,0.0000]2,0,0.0000]2,1,0.0000]2,2,0.0000]2,3,0.0000]2,4,0.0000]2,5,0.8197]2,6,0.8004]2,7,0.0000]2,8,0.6124]2,9,0.0000]2,10,0.0000]2,11,0.0000]2,12,0.0000]2,13,0.5995]2,14,0.0000]2,15,0.0000]2,16,0.0000]2,17,0.0000]2,18,0.0000]2,19,0.0000]3,0,0.0000]3,1,0.0000]3,2,0.0000]3,3,0.0000]3,4,0.0000]3,5,0.0000]3,6,0.8292]3,7,0.7706]3,8,0.0000]3,9,0.0000]3,10,0.0000]3,11,0.0000]3,12,0.0000]3,13,0.6847]3,14,0.8292]3,15,0.0000]3,16,0.0000]3,17,0.7806]3,18,0.8197]3,19,0.0000]4,0,0.0000]4,1,0.0000]4,2,0.0000]4,3,0.0000]4,4,0.0000]4,5,0.0000]4,6,0.0000]4,7,0.0000]4,8,0.0000]4,9,0.0000]4,10,0.0000]4,11,0.0000]4,12,0.0000]4,13,0.0000]4,14,0.0000]4,15,0.0000]4,16,0.0000]4,17,0.0000]4,18,0.0000]4,19,0.0000]5,0,0.0000]5,1,0.0000]5,2,0.0000]5,3,0.0000]5,4,0.0000]5,5,0.0000]5,6,0.0000]5,7,0.0000]5,8,0.0000]5,9,0.8839]5,10,0.7071]5,11,0.0000]5,12,0.0000]5,13,0.0000]5,14,0.0000]5,15,0.0000]5,16,0.0000]5,17,0.0000]5,18,0.0000]5,19,0.0000]6,0,0.0000]6,1,0.0000]6,2,0.0000]6,3,0.0000]6,4,0.0000]6,5,0.0000]6,6,0.0000]6,7,0.0000]6,8,0.0000]6,9,0.0000]6,10,0.0000]6,11,0.9186]6,12,0.6374]6,13,0.0000]6,14,0.0000]6,15,0.0000]6,16,0.0000]6,17,0.0000]6,18,0.0000]6,19,0.0000]7,0,0.0000]7,1,0.0000]7,2,0.0000]7,3,0.0000]7,4,0.0000]7,5,0.0000]7,6,0.0000]7,7,0.0000]7,8,0.0000]7,9,0.0000]7,10,0.0000]7,11,0.0000]7,12,0.0000]7,13,0.0000]7,14,0.0000]7,15,0.0000]7,16,0.0000]7,17,0.0000]7,18,0.0000]7,19,0.0000]8,0,0.0000]8,1,0.0000]8,2,0.0000]8,3,0.0000]8,4,0.0000]8,5,0.0000]8,6,0.0000]8,7,0.0000]8,8,0.0000]8,9,0.0000]8,10,0.0000]8,11,0.0000]8,12,0.8197]8,13,0.6250]8,14,0.0000]8,15,0.0000]8,16,0.0000]8,17,0.0000]8,18,0.0000]8,19,0.0000]9,0,0.0000]9,1,0.0000]9,2,0.8101]9,3,0.8197]9,4,0.8101]9,5,0.8101]9,6,0.0000]9,7,0.0000]9,8,0.0000]9,9,0.0000]9,10,0.0000]9,11,0.0000]9,12,0.0000]9,13,0.0000]9,14,0.0000]9,15,0.0000]9,16,0.0000]9,17,0.0000]9,18,0.0000]9,19,0.0000]10,0,0.0000]10,1,0.0000]10,2,0.0000]10,3,0.0000]10,4,0.0000]10,5,0.0000]10,6,0.0000]10,7,0.0000]10,8,0.0000]10,9,0.0000]10,10,0.0000]10,11,0.0000]10,12,0.0000]10,13,0.0000]10,14,0.0000]10,15,0.0000]10,16,0.0000]10,17,0.0000]10,18,0.0000]10,19,0.0000]11,0,0.0000]11,1,0.0000]11,2,0.0000]11,3,0.0000]11,4,0.0000]11,5,0.0000]11,6,0.0000]11,7,0.0000]11,8,0.0000]11,9,0.0000]11,10,0.0000]11,11,0.0000]11,12,0.0000]11,13,0.0000]11,14,0.0000]11,15,0.0000]11,16,0.0000]11,17,0.0000]11,18,0.0000]11,19,0.0000]12,0,0.0000]12,1,0.0000]12,2,0.0000]12,3,0.0000]12,4,0.0000]12,5,0.0000]12,6,0.0000]12,7,0.0000]12,8,0.0000]12,9,0.0000]12,10,0.0000]12,11,0.0000]12,12,0.0000]12,13,0.0000]12,14,0.0000]12,15,0.0000]12,16,0.0000]12,17,0.0000]12,18,0.0000]12,19,0.0000]13,0,0.0000]13,1,0.0000]13,2,0.0000]13,3,0.0000]13,4,0.0000]13,5,0.0000]13,6,0.0000]13,7,0.0000]13,8,0.0000]13,9,0.0000]13,10,0.0000]13,11,0.0000]13,12,0.0000]13,13,0.0000]13,14,0.0000]13,15,0.0000]13,16,0.0000]13,17,0.0000]13,18,0.0000]13,19,0.0000]14,0,0.0000]14,1,0.0000]14,2,0.0000]14,3,0.0000]14,4,0.0000]14,5,0.0000]14,6,0.0000]14,7,0.0000]14,8,0.0000]14,9,0.0000]14,10,0.0000]14,11,0.0000]14,12,0.0000]14,13,0.0000]14,14,0.0000]14,15,0.0000]14,16,0.0000]14,17,0.0000]14,18,0.0000]14,19,0.0000]15,0,0.0000]15,1,0.0000]15,2,0.0000]15,3,0.0000]15,4,0.0000]15,5,0.0000]15,6,0.0000]15,7,0.0000]15,8,0.0000]15,9,0.0000]15,10,0.0000]15,11,0.0000]15,12,0.0000]15,13,0.0000]15,14,0.0000]15,15,0.0000]15,16,0.0000]15,17,0.0000]15,18,0.0000]15,19,0.0000]16,0,0.0000]16,1,0.0000]16,2,0.0000]16,3,0.0000]16,4,0.0000]16,5,0.0000]16,6,0.0000]16,7,0.7906]16,8,0.7500]16,9,0.0000]16,10,0.0000]16,11,0.0000]16,12,0.0000]16,13,0.0000]16,14,0.0000]16,15,0.0000]16,16,0.0000]16,17,0.0000]16,18,0.0000]16,19,0.0000]17,0,0.8004]17,1,0.8478]17,2,0.0000]17,3,0.0000]17,4,0.0000]17,5,0.0000]17,6,0.0000]17,7,0.0000]17,8,0.0000]17,9,0.0000]17,10,0.0000]17,11,0.0000]17,12,0.0000]17,13,0.0000]17,14,0.0000]17,15,0.0000]17,16,0.0000]17,17,0.0000]17,18,0.0000]17,19,0.0000]18,0,0.0000]18,1,0.0000]18,2,0.0000]18,3,0.0000]18,4,0.0000]18,5,0.0000]18,6,0.0000]18,7,0.0000]18,8,0.0000]18,9,0.0000]18,10,0.0000]18,11,0.0000]18,12,0.0000]18,13,0.0000]18,14,0.0000]18,15,0.0000]18,16,0.0000]18,17,0.0000]18,18,0.8101]18,19,0.8570]19,0,0.0000]19,1,0.7806]19,2,0.8004]19,3,0.8004]19,4,0.8004]19,5,0.0000]19,6,0.0000]19,7,0.0000]19,8,0.0000]19,9,0.0000]19,10,0.0000]19,11,0.0000]19,12,0.0000]19,13,0.0000]19,14,0.0000]19,15,0.7706]19,16,0.8004]19,17,0.0000]19,18,0.0000]19,19,0.0000]20,0,0.0000]20,1,0.0000]20,2,0.0000]20,3,0.0000]20,4,0.0000]20,5,0.0000]20,6,0.0000]20,7,0.0000]20,8,0.0000]20,9,0.0000]20,10,0.0000]20,11,0.0000]20,12,0.0000]20,13,0.0000]20,14,0.0000]20,15,0.0000]20,16,0.0000]20,17,0.0000]20,18,0.0000]20,19,0.0000]21,0,0.0000]21,1,0.0000]21,2,0.0000]21,3,0.0000]21,4,0.0000]21,5,0.0000]21,6,0.0000]21,7,0.0000]21,8,0.0000]21,9,0.0000]21,10,0.0000]21,11,0.0000]21,12,0.0000]21,13,0.0000]21,14,0.0000]21,15,0.0000]21,16,0.0000]21,17,0.0000]21,18,0.0000]21,19,0.0000]22,0,0.0000]22,1,0.0000]22,2,0.0000]22,3,0.0000]22,4,0.0000]22,5,0.0000]22,6,0.0000]22,7,0.0000]22,8,0.0000]22,9,0.0000]22,10,0.0000]22,11,0.0000]22,12,0.0000]22,13,0.0000]22,14,0.0000]22,15,0.0000]22,16,0.0000]22,17,0.0000]22,18,0.0000]22,19,0.0000]23,0,0.0000]23,1,0.0000]23,2,0.0000]23,3,0.0000]23,4,0.0000]23,5,0.0000]23,6,0.0000]23,7,0.0000]23,8,0.0000]23,9,0.0000]23,10,0.0000]23,11,0.0000]23,12,0.0000]23,13,0.0000]23,14,0.8101]23,15,0.9270]23,16,0.8570]23,17,0.9100]23,18,0.0000]23,19,0.0000]24,0,0.0000]24,1,0.0000]24,2,0.0000]24,3,0.0000]24,4,0.0000]24,5,0.0000]24,6,0.0000]24,7,0.0000]24,8,0.0000]24,9,0.0000]24,10,0.0000]24,11,0.0000]24,12,0.0000]24,13,0.0000]24,14,0.0000]24,15,0.0000]24,16,0.0000]24,17,0.0000]24,18,0.0000]24,19,0.0000]25,0,0.0000]25,1,0.0000]25,2,0.0000]25,3,0.0000]25,4,0.0000]25,5,0.0000]25,6,0.0000]25,7,0.0000]25,8,0.0000]25,9,0.0000]25,10,0.0000]25,11,0.0000]25,12,0.0000]25,13,0.0000]25,14,0.0000]25,15,0.0000]25,16,0.0000]25,17,0.0000]25,18,0.0000]25,19,0.0000]26,0,0.0000]26,1,0.0000]26,2,0.0000]26,3,0.0000]26,4,0.0000]26,5,0.0000]26,6,0.0000]26,7,0.0000]26,8,0.0000]26,9,0.0000]26,10,0.0000]26,11,0.0000]26,12,0.0000]26,13,0.0000]26,14,0.0000]26,15,0.0000]26,16,0.0000]26,17,0.0000]26,18,0.0000]26,19,0.0000]27,0,0.0000]27,1,0.0000]27,2,0.0000]27,3,0.0000]27,4,0.0000]27,5,0.0000]27,6,0.0000]27,7,0.0000]27,8,0.0000]27,9,0.0000]27,10,0.8570]27,11,0.6250]27,12,0.0000]27,13,0.0000]27,14,0.0000]27,15,0.0000]27,16,0.0000]27,17,0.0000]27,18,0.0000]27,19,0.0000]28,0,0.0000]28,1,0.0000]28,2,0.0000]28,3,0.0000]28,4,0.0000]28,5,0.0000]28,6,0.0000]28,7,0.0000]28,8,0.0000]28,9,0.0000]28,10,0.0000]28,11,0.0000]28,12,0.0000]28,13,0.0000]28,14,0.0000]28,15,0.0000]28,16,0.0000]28,17,0.0000]28,18,0.0000]28,19,0.0000]29,0,0.0000]29,1,0.0000]29,2,0.0000]29,3,0.0000]29,4,0.0000]29,5,0.0000]29,6,0.0000]29,7,0.0000]29,8,0.0000]29,9,0.0000]29,10,0.0000]29,11,0.0000]29,12,0.0000]29,13,0.0000]29,14,0.0000]29,15,0.0000]29,16,0.0000]29,17,0.0000]29,18,0.0000]29,19,0.0000]30,0,0.0000]30,1,0.0000]30,2,0.0000]30,3,0.0000]30,4,0.0000]30,5,0.0000]30,6,0.0000]30,7,0.0000]30,8,0.0000]30,9,0.0000]30,10,0.0000]30,11,0.0000]30,12,0.0000]30,13,0.0000]30,14,0.0000]30,15,0.0000]30,16,0.0000]30,17,0.0000]30,18,0.0000]30,19,0.0000]31,0,0.0000]31,1,0.0000]31,2,0.0000]31,3,0.0000]31,4,0.0000]31,5,0.0000]31,6,0.0000]31,7,0.0000]31,8,0.0000]31,9,0.0000]31,10,0.0000]31,11,0.0000]31,12,0.0000]31,13,0.0000]31,14,0.0000]31,15,0.0000]31,16,0.0000]31,17,0.0000]31,18,0.0000]31,19,0.0000
 */


