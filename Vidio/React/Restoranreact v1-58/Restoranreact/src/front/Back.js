import Nav from './Nav';
import Side from './Side';
import Main from './Main';
import Footer from './footer';

const Back = () => {
    return (
        <div className="front">
            <Nav />
            <div className="content">
                <Side />
                <Main />
            </div>
            <Footer />
        </div>
    );
};
export default Back;