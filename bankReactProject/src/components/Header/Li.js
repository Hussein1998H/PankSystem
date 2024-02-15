import { Link } from "react-router-dom";
const Li = (props) => {
  return (
    <li className={props.class}><Link to={props.linkpath} className={props.classLink}>{props.name}</Link></li>
  )
}

export default Li