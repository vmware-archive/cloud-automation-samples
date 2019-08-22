/*
# VMware Tito Application Test Sample
#
# Copyright 2019 VMware, Inc. All rights reserved
#
# The BSD-2 license (the "License") set forth below applies to all parts of the
# Cloud-automation-samples Code project. You may not use this file except in compliance
# with the License.
#
# BSD-2 License
#
# Redistribution and use in source and binary forms, with or without
# modification, are permitted provided that the following conditions are met:
#
# Redistributions of source code must retain the above copyright notice, this
# list of conditions and the following disclaimer.
# 
# Redistributions in binary form must reproduce the above copyright notice,
# this list of conditions and the following disclaimer in the documentation
# and/or other materials provided with the distribution.
# 
# THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
# AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
# IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
# ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
# LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
# CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
# SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
# INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
# CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
# ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
# POSSIBILITY OF SUCH DAMAGE.
*/

/// <reference types="Cypress" />
//test data here
let addresses = [
  {
    home: "San Francisco, CA, USA",
    work: "VMware Hilltop B, Hillview Avenue, Palo Alto, CA, USA"
  },
  {
    home: "Princeton, NJ, USA",
    work: "New York, NY, USA"
  },
  {
    home: "Grays Point NSW, Australia",
    work: "175 Pitt Street,Sydney NSW, Australia"
  },
];
context('Actions', () => {
  beforeEach(() => {
    //assumes environment variable set on execution
    cy.visit(Cypress.env('host'+/Tito/))
  })
    for (let i=0; i<addresses.length; i+=1) {
        // https://on.cypress.io/interacting-with-elements
        it('.type() - type into a DOM element', () => {
            cy.get('#home')
                .type(addresses[i].home).should('have.value', addresses[i].home)
            cy.get('#work')
                .type(addresses[i].work).should('have.value',addresses[i].work)  
            cy.get('[name="home_time"]').select('07:00')
            cy.get('.col-lg-offset-2 > .form-group > .service-item > .select-date').select('17:00')
            cy.get('#submit').click('top')
                   
        })
    }
  
})
