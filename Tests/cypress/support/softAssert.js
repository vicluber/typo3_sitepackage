// ***********************************************************
// This contains functions for soft insertions.
//
// Soft assertions allow to keep testing even after failures 
// occured!
//
// Source: https://stackoverflow.com/questions/55868107/does-cypress-support-soft-assertion
// 
// How to use:
// 1.) import functions: 
// const { softAssert, softExpect } = chai;
//
// 2.) call functions:
// either:	softAssert(val == expectedValue, 'message');
// or: 		softExpect(val).to.eq(expectedValue);
//
// To help generate a message quicker, use the function
// generateMessage(description, actual, expected)
// ***********************************************************

let isSoftAssertion = false;
let errors = [];

chai.softExpect = function ( ...args ) {
    isSoftAssertion = true;
    return chai.expect(...args);
},
chai.softAssert = function ( ...args ) {
    isSoftAssertion = true;
    return chai.assert(...args);
}

const origAssert = chai.Assertion.prototype.assert;
chai.Assertion.prototype.assert = function (...args) {
    if ( isSoftAssertion ) {
        try {
            origAssert.call(this, ...args)
        } catch ( error ) {
            errors.push(error);
        }
        isSoftAssertion = false;
    } else {

        origAssert.call(this, ...args)
    }
};

// monkey-patch `Cypress.log` so that the last `cy.then()` isn't logged to command log
const origLog = Cypress.log;
Cypress.log = function ( data ) {
    if ( data && data.error && /soft assertions/i.test(data.error.message) ) {
        data.error.message = '\n\n\t' + data.error.message + '\n\n';
        throw data.error;
    }
    return origLog.call(Cypress, ...arguments);
};

// monkey-patch `it` callback so we insert `cy.then()` as a last command 
// to each test case where we'll assert if there are any soft assertion errors
function itCallback ( func ) {
    func();
    cy.then(() => {
        if ( errors.length ) {
            const _ = Cypress._;
            let msg = '';

            if ( Cypress.browser.isHeaded ) {

                msg = 'Failed soft assertions... check log above ↑';
            } else {

                _.each( errors, error => {
                    msg += '\n' + error;
                });

                msg = msg.replace(/^/gm, '\t');
            }

            throw new Error(msg);
        }
    });
}

const origIt = window.it;
window.it = (title, func) => {
    origIt(title, func && (() => itCallback(func)));
};
window.it.only = (title, func) => {
    origIt.only(title, func && (() => itCallback(func)));
};
window.it.skip = (title, func) => {
    origIt.skip(title, func);
};

beforeEach(() => {
    errors = [];
});
afterEach(() => {
    errors = [];
    isSoftAssertion = false;
});


// Custom Functions

/**
 * Generates an assertion message
 *
 * @param string description, describes what is being tested
 * @param string actual, the actual value of your result
 * @param string expected, the expected value
 * @return string
 */
chai.generateMessage = function ( description, actual, excepted) {
	return description + '. Found: \'' + actual + '\', expected: \'' + excepted + '\'';
}