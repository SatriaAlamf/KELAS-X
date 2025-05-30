import Nav from './Nav';
import Side from './Side';
import Main from './Main';
import Footer from './footer';

function Front() {
    return (
        <div>
            <Nav />
            <div style={{ display: 'flex' }}>
                <Side />
                <Main />
            </div>
            <Footer />
        </div>
    );
}

export default Front;