
const BoxItem = (props) => {
 
  return (
    <>

         <div className={props.clsname}>
             <i className={props.iconname} aria-hidden="true"></i>
             <p>{props.itemNumber}</p>
          </div>
          
    </>
  )
}

export default BoxItem