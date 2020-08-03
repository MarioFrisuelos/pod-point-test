import React, { Component } from 'react'
import Energy from '../energy.png'
import axios from 'axios'
import { StatusInput } from './HomeComponents/StatusInput'

class Home extends Component {

  state = {
    units: []
  }

  componentDidMount(){
    axios.get('http://127.0.0.1:8000/units')
      .then(res => {
        // console.log(res);
        this.setState({
          units: res.data.slice(0,10)
        });
      })
  }

  handleStatusChange(unitId, chargeId) {
    console.log(unitId+" "+chargeId);
    const url = 'http://127.0.0.1:8000/units/'+unitId+'/charges/'+chargeId;
    axios({
      method: 'put',
      url: url,
      data: {
        end: Date.now()
      }
    }).then(function(response) {
      // console.log(response);
    });
  }

  render(){
    const { units } = this.state

    const unitList = units.length ? (
      units.map(unit => {
        // console.log(unit.charges);
        let chargesMessages;
        let buttonStatus;
        if (unit.charges === undefined) {
          chargesMessages = <p className="second-info">No charges yet</p>
          buttonStatus = <p className="second-info center-align">No charges yet</p>
        } else {
          if (unit.charges.length > 1) {
            chargesMessages = <p className="second-info">{unit.charges.length} Charges</p>
          } else {
            chargesMessages = <p className="second-info">{unit.charges.length} Charge</p>
          }
          let chargeId;
          unit.charges.map(charge => {
            chargeId = charge.id;
          });
          buttonStatus = <StatusInput 
                    status={unit.status}
                    unitId={unit.id}
                    chargeId={chargeId}
                    onChangeStatus={this.handleStatusChange}
                    />
        }

        return (
          <div className="unit card" key={unit.id}>
            <img src={Energy} alt="Energy" />
            <div className="card-content">
              <div className="row">
                <div className="col s9">
                  <span className="card-title black-text">{unit.name}</span>
                  <p className="second-info">{unit.address} - {unit.postcode}</p>
                </div>
                <div className="col s3">
                  {buttonStatus}
                </div>
              </div>
              <div className="row">
                <div className="col s12 center-align">
                  {chargesMessages}
                </div>
              </div>
            </div>
          </div>
        )
      })
    ) : (
      <div className="center">No units to show</div>
    );

    return (
      <div>
        <div className="container home">
          {unitList}
        </div>
      </div>
    )
  }
}

export default Home