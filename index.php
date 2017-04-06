<?php
require_once 'includes/db.php';

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Тестовое задание</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.0.2/react.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.0.2/react-dom.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.3/JSXTransformer.js"></script>
</head>
<body>
  <div id="app"></div>

  <script type="text/jsx">
  class App extends React.Component {
    constructor(props) {
      super(props)
      this.state = { isModalOpen: false }
    }

    render() {
      return (

        <div>
          <button onClick={() => this.openModal()}>Записаться!</button>
          <Modal isOpen={this.state.isModalOpen} onClose={() => this.closeModal()}>
           <form action="index2.php" method="POST">
            <label> Время</label>
            <select name="select">
            <?php
              for ($i=9; $i <= 19; $i++) { 
              echo '<option >'.$i.'.00'.'</option>';
             }
            ?>
            </select>
              <br></br>
              <label>Ваше имя</label>
              <input type="text" name="text"></input>
              <br></br>
              <label>Ваш Email@</label>
              <input type="text" name="e-mail"></input>
              <br></br>
                <p><button type="submit"> Go!!!!</button></p>
                
            
              </form>
          
            
          </Modal>
        </div>
      )

    }

    openModal() {
      this.setState({ isModalOpen: true })
    }

    closeModal() {
      this.setState({ isModalOpen: false })
    }
  }

  class Modal extends React.Component {
    render() {
      if (this.props.isOpen === false)
        return null

      let modalStyle = {
        position: 'absolute',
        top: '50%',
        left: '50%',
        transform: 'translate(-50%, -50%)',
        zIndex: '9999',
        background: '#fff'
      }

      if (this.props.width && this.props.height) {
        modalStyle.width = this.props.width + 'px'
        modalStyle.height = this.props.height + 'px'
        modalStyle.marginLeft = '-' + (this.props.width/2) + 'px',
        modalStyle.marginTop = '-' + (this.props.height/2) + 'px',
        modalStyle.transform = null
      }

      if (this.props.style) {
        for (let key in this.props.style) {
          modalStyle[key] = this.props.style[key]
        }
      }

      let backdropStyle = {
        position: 'absolute',
        width: '100%',
        height: '100%',
        top: '0px',
        left: '0px',
        zIndex: '9998',
        background: 'rgba(0, 0, 0, 0.3)'
      }

      if (this.props.backdropStyle) {
        for (let key in this.props.backdropStyle) {
          backdropStyle[key] = this.props.backdropStyle[key]
        }
      }

      return (
        <div className={this.props.containerClassName}>
          <div className={this.props.className} style={modalStyle}>
            {this.props.children}
          </div>
          {!this.props.noBackdrop &&
              <div className={this.props.backdropClassName} style={backdropStyle}
                   onClick={e => this.close(e)}/>}
        </div>
      )
    }

    close(e) {
      e.preventDefault()

      if (this.props.onClose) {
        this.props.onClose()
      }
    }
  }

  ReactDOM.render(<App/>, document.getElementById('app'))
  </script>
  
  <?php
if (empty($_POST['text']) || empty($_POST['e-mail'])) {
  echo "Забронируйте места !";
}else{
  

$text = $_POST['text'];
$email = $_POST['e-mail'];
$select = $_POST['select'];

$text = "Имя пользователя ".$text." -- ";
$email = "email пользователя ".$email." -- ";
$select = "Время бронирования ".$select." -- "; 

$zakaz = $text.$email.$select."\r\n";

$fp = fopen('text.txt', 'a');
fwrite($fp, $zakaz . PHP_EOL);
fclose($fp);
echo "Данные записаны в файл";
unset($_POST['text'],$_POST['e-mail']);
header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?success'); exit();
}


?>
</body>
</html>
