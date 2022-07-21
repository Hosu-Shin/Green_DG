<?php
    namespace application\controllers;

    class ApiController extends Controller {
        public function categoryList() {
            return $this->model->getCategoryList();
        }

        public function productInsert() {
            $json = getJson();
            print_r($json);
            return [_RESULT => $this->model->productInsert($json)];
        }

        public function productList2() {
            $result = $this->model->productList2();
            return $result === false ? [] : $result;
        }

        public function productDetail() {
            $urlPaths = getUrlPaths();
            if(!isset($urlPaths[2])) {
                exit();
            }
            $param = [
                'product_id' => intval($urlPaths[2])
            ];
            return $this->model->productDetail($param);
        }

        public function upload() {
            $urlPaths = getUrlPaths();
            if(!isset($urlPaths[2]) || !isset($urlPaths[3])) {
                exit();
            }
            $productId = intval($urlPaths[2]);
            $type = intval($urlPaths[3]);
            $json = getJson();
            $image_parts = explode(";base64,", $json["image"]);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $dirPath = _IMG_PATH . "/" . $productId . "/" . $type;
            $path = uniqid() . "." . $image_type;
            $filePath = $dirPath . "/" . $path;
            if(!is_dir($dirPath)) {
                mkdir($dirPath, 0777, true);
            }
            $result = file_put_contents($filePath, $image_base64);
            

            $param = [
                'product_id' => $productId,
                'type' => $type,
                // 'path' => $path 
                'path' => end(explode("/",$filePath)) //end: 배열의 마지막 값 가져오기
            ];

            $this->model->productImageInsert($param);
            return [_RESULT => $result ? 1 : 0];
        }

        public function productImageList() {
            $urlPaths = getUrlPaths();
            if(!isset($urlPaths[2])) {
                exit();
            }
            $productId = intval($urlPaths[2]);
            $param =[
                'product_id' =>$productId
            ];
            return $this->model->productImageList($param);
        }

        public function productImageDelete() {
            $urlPaths = getUrlPaths();
            if(!isset($urlPaths[2])) {
                exit();
            }
            $result = 0;
            switch(getMethod()) {
                case _DELETE:
                    //이미지 파일 삭제
                    /*
                    $productId = intval($urlPaths[2]);
                    print_r($urlPaths);
                    $type = intval($urlPaths[3]);
                    $path = $urlPaths[4];

                    $dirPath = _IMG_PATH . "/" . $productId . "/" . $type . "/" . $path;
                    print $dirPath;
                    unlink($dirPath);

                    $param = ["product_image_id" => intval($urlPaths[5]) ];
                    */
                    $product_image_id = intval($urlPaths[2]);
                    $product_id = intval($urlPaths[3]);
                    $type = intval($urlPaths[4]);
                    $path = $urlPaths[5];

                    $imgPath = _IMG_PATH . "/" . $product_id . "/" . $type . "/" . $path;
                    if(unlink($imgPath)) {
                        $param = ["product_image_id" => $product_image_id ];
                        $result = $this->model->productImageDelete($param);
                    }
                    break;
            }

            return [_RESULT => $result];
        }
        

    }
