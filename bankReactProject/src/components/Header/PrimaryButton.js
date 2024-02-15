import {Link} from 'react-router-dom'
const PrimaryButton = (props) => {
  return (
    <Link to='/login'>
      <button className="primaru-btn">
       <i className={props.icn} style={{'padding':'0 5px'}}></i>
        {props.name}
        </button>
    </Link>
  )
}

export default PrimaryButton