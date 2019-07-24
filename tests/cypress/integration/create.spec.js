describe('Comment form', () => {
    it('loads', () => {
        cy.visit('create')
        cy.get('form')
        cy.get('form span>strong').should('not.exist')
    })
    it('shows errors when fields are required', () => {
        cy.visit('create')
        cy.get('form').submit()
        cy.get('form span>strong')
    })
    it('shows error when data is invalid', () => {
        cy.visit('create')
        cy.get('#email').type('a@a')
        cy.get('#age').type('old')
        cy.get('form').submit()
        cy.get('#email').next('span').contains('The email format is invalid')
        cy.get('#age').next('span').contains('The age must be an integer')
    })
})
