import React from 'react';
import Energy from '../energy.png'

export function Footer() {
    return (
        <footer className="page-footer white black-text">
          <div className="container">
            <div className="row">
              <div className="col s4 center-align">
                <i className="medium material-icons">star_border</i>
                <h6>Favourites</h6>
              </div>
              <div className="col s4 center-align">
                <i className="medium material-icons">settings_power</i>
                <h6>Units</h6>
              </div>
              <div className="col s4 center-align">
                <i className="medium material-icons">account_circle</i>
                <h6>Account</h6>
              </div>
            </div>
          </div>
        </footer>
    )
}

export default Footer;