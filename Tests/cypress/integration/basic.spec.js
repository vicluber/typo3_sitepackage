describe('Suedbahnhotel Basic Tests', () => {
	
    const url = Cypress.env('host');
    
	let componentsToCheck = [
		{
			'selector' : '.slick-list .slick-current.slick-active'
        },
        {
			'selector' : '.news-list-view .article.topnews'
        }
	];
	
	before(() => {
		//accept cookie
		cy.acceptCookies()
		//visit website
		cy.visit(url)		
    })
    
    it('check if slider elements exist', () => {
        cy.get(componentsToCheck[0]['selector']).should('exist');
    })

    it('check if news elements exists', () => {
        cy.get(componentsToCheck[1]['selector']).should('exist');
    })

    it('check all links to sites', () => {
        cy.get(".main-nav .nav-main-sub a:not([href*='mailto:'])").each(page => {
            cy.request(page.prop('href'))
        })
    })
})