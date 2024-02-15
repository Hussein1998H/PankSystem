import './serveces.css';
const CardServices = (props) => {
  return (
    <div className="card-ser">
        {/* <div className="img"><i className={props.icon} aria-hidden="true" 
        style={{'marginTop':'20px',
        'color':'#f00',
        'fontSize':'60px'
        }}></i></div> */}
        <div className='card-img-service' style={{'backgroundImage':`url("${props.img}")`,}}></div>
        <h3 className='title'>{props.title}</h3>
        <h4 className="des">{props.des}</h4>
    </div>
  )
}

export default CardServices