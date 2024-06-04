<!DOCTYPE html>
<html lang="kr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <link rel="stylesheet" href="style.css">
    <title></title>

    <style>

.btn {
    border: none;
    background-color: lightgray;
    border-radius: 5px;
    height: 25px;
    color: black;
  }
  
  .column {
    margin-bottom: 300px;
  }
  
  .search {
    text-align: center;
    margin-bottom: 30px;
  }
  
  table {
    /* border-top: 1px solid #444444; */
  
    border-collapse: collapse;
    width: 1200px;
    margin-bottom: 30px;
  }
  
  tr {
    border-bottom: 1px solid #444444;
  
    padding: 10px;
  }
  
  td {
    border-bottom: 1px solid #efefef;
  
    padding: 10px;
  }
  
  .htd {
    font-weight: bold;
    font-size: 18px;
    border-bottom: black;
  }
  
  #search_opt,
  .textform {
    border: 1px solid #d9d9d9;
    border-radius: 5px;
    width: 300px;
    height: 30px;
  }
  
  .submit {
    width: 60px;
    height: 33px;
    border-radius: 5px;
    border: 1px solid gray;
    background: white;
    cursor: pointer;
  }
  
  .write {
    text-align: center;
    margin-bottom: 30px;
  }
  
  .write button {
    width: 60px;
    height: 40px;
    border-radius: 5px;
    background: black;
    color: white;
    font-weight: bold;
    cursor: pointer;
  }
  
  a:link {
    color: #57a0ee;
    text-decoration: none;
  }
  
  .paging {
    text-align: center;
  }
  
  .paging a {
    color: black;
    font-weight: bold;
    font-size: 15px;
  }
  
  .paging a:hover {
    color: gray;
  }

  /* 검색 css */
  /* body{
    margin: 0;
    padding: 0;
    background-color: #fff;
  }  */
  .search-box {
    display: inline-block;
    position: relative;
    border: 1px solid #51e3d4;
    border-radius: 30px;
    transition: 0.4s;
    width: 30px;
    overflow: hidden;
}

.search-box:hover {
    box-shadow: 0px 0px 0.5px 1px #51e3d4;
    width: 282px;
}

.search-txt {
    width: 0;
    padding: 0;
    border: none;
    background: none;
    outline: none;
    float: left;
    font-size: 1rem;
    line-height: 30px;
    transition: 0.4s;
}

.search-box:hover .search-txt {
    width: 240px;
    padding: 0 6px;
}

.search-btn {
    text-decoration: none;
    float: right;
    width: 30px;
    height: 30px;
    background-color: #fff;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #51e3d4;
} 
  
  
    </style>
  </head>
  <body>
    <div class="search-box">
      <input type="text" class="search-txt" name=""placeholder="Type to search">
      <a class="search-btn" href="#">
        <i class="fas fa-search"></i>
      </a>
    </div>
  </body>
</html>