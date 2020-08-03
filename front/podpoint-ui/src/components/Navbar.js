import React from 'react';
import { withRouter } from 'react-router-dom'

const Navbar = (props) => {
  return (
    <nav className="nav-wrapper green darken-3">
      <div className="container">
      	<h2 className="center-align">Units</h2>
      </div>
    </nav> 
  )
}

export default withRouter(Navbar)